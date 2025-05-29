function validateForm() {
  console.log("Validating...");
  try {
    var fn = document.querySelector('input[name="first_name"]').value;
    var ln = document.querySelector('input[name="last_name"]').value;
    var hd = document.querySelector('input[name="headline"]').value;
    if (!fn || !ln || !hd) {
      alert("All fields must be filled out");
      return false;
    }
    return true;
  } catch (e) {
    return false;
  }
}
