const contactForm = document.getElementById("contact-form");
const loader = document.querySelector(".loader");

loader.style.display = "none";

contactForm.addEventListener("submit", function (e) {
  e.preventDefault();
  loader.style.display = "block";
  const url = e.target.action;
  const formData = new FormData(contactForm);

  // Validate form fields before submission
  let isValid = true;
  for (const [name, value] of formData.entries()) {
    if (!value.trim()) {
      isValid = false;
      break;
    }
  }

  if (isValid) {
    fetch(url, {
      method: "POST",
      body: formData,
      mode: "no-cors",
    })
      .then(() => {
        loader.style.display = "none";
        window.location.href = "./thankyou.html";
      })
      .catch(() => {
        alert("Terjadi kesalahan saat mengirimkan formulir. Silakan coba lagi nanti");
        loader.style.display = "none";
      });
  } else {
    alert("Silakan lengkapi semua kolom sebelum mengirimkan formulir");
    loader.style.display = "none";
  }
});
9