function showForm(formId){
    document.querySelectorAll(".card.form-box").forEach(form => form.classList.remove("active"))
    document.getElementById(formId).classList.add("active");
}