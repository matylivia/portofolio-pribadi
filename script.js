document.addEventListener("DOMContentLoaded", function () {
  // Mobile menu toggle
  const menuIcon = document.getElementById("menu-icon");
  const navbar = document.querySelector(".navbar");

  menuIcon.addEventListener("click", () => {
    navbar.classList.toggle("active");
  });

  // Close menu when clicking on a link
  const navLinks = document.querySelectorAll(".navbar a");
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      navbar.classList.remove("active");
    });
  });

  // Active link based on scroll position
  const sections = document.querySelectorAll("section");
  window.addEventListener("scroll", () => {
    let current = "";

    sections.forEach((section) => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.clientHeight;

      if (pageYOffset >= sectionTop - 300) {
        current = section.getAttribute("id");
      }
    });

    navLinks.forEach((link) => {
      link.classList.remove("active");
      if (link.getAttribute("href") === `#${current}`) {
        link.classList.add("active");
      }
    });
  });

  // Smooth scrolling for anchor links
  navLinks.forEach((link) => {
    if (link.getAttribute("href").startsWith("#")) {
      link.addEventListener("click", (e) => {
        e.preventDefault();

        const targetId = link.getAttribute("href");
        const targetElement = document.querySelector(targetId);

        window.scrollTo({
          top: targetElement.offsetTop - 80,
          behavior: "smooth",
        });
      });
    }
  });

  // Enhanced interactivity for portfolio items
  const portfolioItems = document.querySelectorAll(".portfolio-item");

  portfolioItems.forEach((item) => {
    item.addEventListener("mousemove", function (e) {
      const rect = this.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      const rotateX = (y - centerY) / 10;
      const rotateY = (centerX - x) / 10;
      this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-10px) scale(1.02)`;
    });

    item.addEventListener("mouseleave", function () {
      this.style.transform = "";
    });

    item.style.opacity = "0";
    item.style.transform = "translateY(50px)";
    setTimeout(() => {
      item.style.transition =
        "all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)";
      item.style.opacity = "1";
      item.style.transform = "translateY(0)";
    }, 100 * parseInt(item.dataset.project));
  });

  document.addEventListener("keydown", function (e) {
    if (e.key >= "1" && e.key <= "5") {
      const projectNumber = e.key;
      const targetItem = document.querySelector(
        `[data-project="${projectNumber}"]`
      );
      if (targetItem) {
        const link = targetItem.querySelector(".project-btn");
        if (link) {
          window.location.href = link.getAttribute("href");
        }
      }
    }
  });

  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.animationPlayState = "running";
      }
    });
  }, observerOptions);

  portfolioItems.forEach((item) => {
    observer.observe(item);
  });
});
 
// Smooth scrolling for article links
document.querySelectorAll('a[href^="articles.html#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
      e.preventDefault();
      
      // Extract the target ID from the href
      const url = this.getAttribute('href');
      const targetId = url.split('#')[1];
      const targetElement = document.getElementById(targetId);
      
      // If we're already on the articles page, scroll to the section
      if (window.location.pathname.endsWith('articles.html')) {
          window.scrollTo({
              top: targetElement.offsetTop - 100,
              behavior: 'smooth'
          });
      } else {
          // Otherwise, navigate to the articles page with the hash
          window.location.href = url;
      }
  });
});
// Handle hash on page load for articles page
document.addEventListener('DOMContentLoaded', function() {
  if (window.location.hash && window.location.pathname.endsWith('articles.html')) {
      const targetId = window.location.hash.substring(1);
      const targetElement = document.getElementById(targetId);
      
      if (targetElement) {
          setTimeout(() => {
              window.scrollTo({
                  top: targetElement.offsetTop - 100,
                  behavior: 'smooth'
              });
          }, 300); // Small delay to allow page to load
      }
  }
});

// Tambahkan ini di bagian event listener form
document.getElementById("contactForm").addEventListener("submit", function(e) {
  e.preventDefault();
  
  // Validasi nomor telepon
  const phoneInput = document.getElementById("phone");
  const phoneError = document.getElementById("phoneError");
  const phoneRegex = /^[0-9]{11,13}$/;
  
  if (!phoneRegex.test(phoneInput.value)) {
      phoneError.textContent = "Nomor telepon harus 11-13 angka";
      return false;
  } else {
      phoneError.textContent = "";
  }
  

});

document.getElementById("phone").addEventListener("input", function () {
  this.value = this.value.replace(/[^0-9]/g, "");
});