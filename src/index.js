(() => {
  "use strict";

  const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  document.addEventListener("DOMContentLoaded", init, { once: true });

  function init() {
    initMobileMenu();
    initNavTransition();
    initTypingEffect();
    initRevealAnimations();
    initFormEnhancements();
    initHeroParticles();
  }

  function initMobileMenu() {
    const nav = document.querySelector("header nav");
    const navLinks = nav?.querySelector(".nav-links");

    if (!nav || !navLinks) {
      return;
    }

    const toggle = document.createElement("button");
    toggle.type = "button";
    toggle.className = "menu-toggle";
    toggle.setAttribute("aria-label", "Toggle navigation menu");
    toggle.setAttribute("aria-expanded", "false");
    toggle.setAttribute("aria-controls", "site-navigation");
    toggle.innerHTML = "<span></span><span></span><span></span>";

    navLinks.id = "site-navigation";
    nav.insertBefore(toggle, navLinks);

    const closeMenu = () => {
      navLinks.classList.remove("is-open");
      toggle.setAttribute("aria-expanded", "false");
    };

    const toggleMenu = () => {
      const isOpen = navLinks.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", String(isOpen));
    };

    toggle.addEventListener("click", toggleMenu);

    navLinks.addEventListener("click", (event) => {
      if (event.target.closest("a")) {
        closeMenu();
      }
    });

    document.addEventListener("click", (event) => {
      if (!window.matchMedia("(max-width: 768px)").matches) {
        return;
      }

      if (!nav.contains(event.target)) {
        closeMenu();
      }
    });

    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape") {
        closeMenu();
      }
    });

    window.addEventListener(
      "resize",
      () => {
        if (window.innerWidth > 768) {
          closeMenu();
        }
      },
      { passive: true }
    );
  }

  function initNavTransition() {
    if (reduceMotion) {
      return;
    }

    const navLinks = document.querySelectorAll('header nav a[href^="?section="]');
    if (!navLinks.length) {
      return;
    }

    navLinks.forEach((link) => {
      link.addEventListener("click", () => {
        document.body.classList.add("is-leaving");
      });
    });
  }

  function initTypingEffect() {
    if (reduceMotion) {
      return;
    }

    const heroTitle = document.querySelector(".hero h1");
    if (!heroTitle) {
      return;
    }

    const text = heroTitle.textContent?.trim();
    if (!text) {
      return;
    }

    heroTitle.textContent = "";
    heroTitle.setAttribute("aria-label", text);

    let index = 1;
    const type = () => {
      heroTitle.textContent = text.slice(0, index);
      index += 1;

      if (index <= text.length + 1) {
        window.setTimeout(type, 45);
      }
    };

    type();
  }

  function initRevealAnimations() {
    const targets = Array.from(
      document.querySelectorAll(".skill-category, .project-card, .timeline-item, .contact-item")
    );

    if (!targets.length) {
      return;
    }

    targets.forEach((target, index) => {
      target.classList.add("reveal");
      target.style.setProperty("--reveal-delay", `${Math.min(index * 40, 260)}ms`);
    });

    if (reduceMotion || !("IntersectionObserver" in window)) {
      targets.forEach((target) => target.classList.add("is-visible"));
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) {
            return;
          }

          entry.target.classList.add("is-visible");
          observer.unobserve(entry.target);
        });
      },
      {
        threshold: 0.14,
        rootMargin: "0px 0px -8% 0px",
      }
    );

    targets.forEach((target) => observer.observe(target));
  }

  function initFormEnhancements() {
    const form = document.querySelector(".contact-form form");
    if (!form) {
      return;
    }

    const fields = form.querySelectorAll("input, textarea");

    fields.forEach((field) => {
      const group = field.closest(".form-group");
      syncFieldState(field, group);

      field.addEventListener("focus", () => {
        group?.classList.add("is-focused");
      });

      field.addEventListener("blur", () => {
        syncFieldState(field, group);
      });

      field.addEventListener("input", () => {
        syncFieldState(field, group);
      });
    });

    form.addEventListener("submit", (event) => {
      const button = form.querySelector('button[type="submit"]');

      if (!form.checkValidity()) {
        event.preventDefault();

        fields.forEach((field) => {
          syncFieldState(field, field.closest(".form-group"), true);
        });

        return;
      }

      if (button) {
        button.disabled = true;
        button.classList.add("is-submitting");
        button.textContent = "Sending...";
      }
    });
  }

  function syncFieldState(field, group, forceValidation = false) {
    if (!group) {
      return;
    }

    const value = field.value.trim();
    const hasValue = value.length > 0;
    const shouldValidate = forceValidation || hasValue;

    group.classList.toggle("is-focused", hasValue || document.activeElement === field);
    group.classList.toggle("is-invalid", shouldValidate && !field.checkValidity());
    field.setAttribute("aria-invalid", String(shouldValidate && !field.checkValidity()));
  }

  function initHeroParticles() {
    if (reduceMotion) {
      return;
    }

    const hero = document.querySelector(".hero");
    if (!hero) {
      return;
    }

    const particleCount = window.matchMedia("(max-width: 768px)").matches ? 12 : 20;
    const fragment = document.createDocumentFragment();

    for (let i = 0; i < particleCount; i += 1) {
      const particle = document.createElement("span");
      particle.className = "hero-particle";
      particle.style.setProperty("--size", `${randomBetween(2, 5.5)}px`);
      particle.style.setProperty("--left", `${randomBetween(0, 100)}%`);
      particle.style.setProperty("--top", `${randomBetween(3, 92)}%`);
      particle.style.setProperty("--duration", `${randomBetween(5.5, 12)}s`);
      particle.style.setProperty("--delay", `${randomBetween(0, 5.5)}s`);
      fragment.appendChild(particle);
    }

    hero.appendChild(fragment);
  }

  function randomBetween(min, max) {
    return (Math.random() * (max - min) + min).toFixed(2);
  }
})();
