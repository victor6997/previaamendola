// sistemas.js  (versão substituição: abre com efeito suave e fica aberto; fecha cobrindo)
document.addEventListener("DOMContentLoaded", () => {
  const items = Array.from(document.querySelectorAll(".accordion-item"));

  // Inicializar estado (suporta .active ou .open inicial no HTML)
  items.forEach(item => {
    const content = item.querySelector(".accordion-content");
    const isOpen = item.classList.contains("active") || item.classList.contains("open");
    if (isOpen) {
      // define maxHeight para o valor real para que fique visível
      content.style.maxHeight = content.scrollHeight + "px";
      content.style.opacity = "1";
      item.classList.add("open");
      // ícone se existir
      const icon = item.querySelector(".icon");
      if (icon) icon.textContent = "−";
    } else {
      content.style.maxHeight = "0px";
      content.style.opacity = "0";
      const icon = item.querySelector(".icon");
      if (icon) icon.textContent = "+";
    }
  });

  // Helpers de animação
  function openItem(item) {
    const header = item.querySelector(".accordion-header");
    const content = item.querySelector(".accordion-content");
    const icon = header.querySelector(".icon");

    // marca animando e faz o header "levantar" primeiro
    item.classList.add("animating");
    header.classList.add("lift");
    header.style.zIndex = 5;

    // pequeno delay para sentir o lift (80ms)
    setTimeout(() => {
      // define maxHeight para o scrollHeight real -> transição de max-height ocorre conforme CSS
      const full = content.scrollHeight;
      content.style.maxHeight = full + "px";
      content.style.opacity = "1";
      // marca como aberto (aplica transform da content via CSS)
      item.classList.add("open");
      // ícone
      if (icon) icon.textContent = "−";

      // quando terminar a transição, limpar flags
      const onEnd = (ev) => {
        if (ev.propertyName === "max-height") {
          item.classList.remove("animating");
          header.classList.remove("lift");
          header.style.zIndex = ""; // remove estilo inline
          content.removeEventListener("transitionend", onEnd);
        }
      };
      content.addEventListener("transitionend", onEnd);
    }, 80);
  }

  function closeItem(item) {
    const header = item.querySelector(".accordion-header");
    const content = item.querySelector(".accordion-content");
    const icon = header.querySelector(".icon");

    // marca animando e prepara o header para descer e cobrir
    item.classList.add("animating");
    header.classList.add("closing");
    header.style.zIndex = 10;

    // força maxHeight atual (garante animação consistente)
    const full = content.scrollHeight;
    content.style.maxHeight = full + "px";

    // next frame -> reduz maxHeight para 0 (vai animar) e esmaece o conteúdo
    requestAnimationFrame(() => {
      // pequena microespera para garantir reflow
      setTimeout(() => {
        content.style.maxHeight = "0px";
        content.style.opacity = "0";
        content.style.transform = "translateY(-6px)";
        if (icon) icon.textContent = "+";
      }, 10);
    });

    // quando animação acabar, limpa classes
    const onEnd = (ev) => {
      if (ev.propertyName === "max-height") {
        item.classList.remove("open");
        item.classList.remove("animating");
        header.classList.remove("closing");
        header.style.zIndex = "";
        content.removeEventListener("transitionend", onEnd);
      }
    };
    content.addEventListener("transitionend", onEnd);
  }

  // Handler de clique
  items.forEach(item => {
    const header = item.querySelector(".accordion-header");
    const content = item.querySelector(".accordion-content");

    header.addEventListener("click", (ev) => {
      ev.preventDefault();
      if (item.classList.contains("animating")) return; // bloqueia cliques enquanto anima

      const isOpen = item.classList.contains("open");
      if (isOpen) {
        // fecha item atual
        closeItem(item);
      } else {
        // fecha os outros de forma suave
        items.forEach(other => {
          if (other !== item && other.classList.contains("open") && !other.classList.contains("animating")) {
            closeItem(other);
          }
        });
        // abre o clicado
        openItem(item);
      }
      
    });
  });
  
});
  window.addEventListener('scroll', function() {
    const header = document.querySelector('.header');
    if (window.scrollY > 50) {
      header.classList.add('shrink');
    } else {
      header.classList.remove('shrink');
    }
  });

