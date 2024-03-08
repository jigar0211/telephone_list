$("#saveUserBtn").click(function () {
  var valid = true;
  $(".form-control").each(function () {
    $(this).css("borderColor", "");
  });
  $(".error-message").text("");

  var firstName = $("#firstName").val().trim();
  if (firstName === "") {
    valid = false;
    $("#firstName").css("borderColor", "red");
    $("#firstname-error").text("Please enter First Name");
  }

  var lastName = $("#lastName").val().trim();
  if (lastName === "") {
    valid = false;
    $("#lastName").css("borderColor", "red");
    $("#lastname-error").text("Please enter Last Name");
  }

  var email = $("#email").val().trim();
  if (email === "") {
    valid = false;
    $("#email").css("borderColor", "red");
    $("#email-error").text("Please enter Email");
  } else if (!validateEmail(email)) {
    valid = false;
    $("#email").css("borderColor", "red");
    $("#email-error").text("Please enter a valid Email");
  }

  var phone = $("#phone").val().trim();
  if (phone === "") {
    valid = false;
    $("#phone").css("borderColor", "red");
    $("#phone-error").text("Please enter Phone Number");
  }

  var password = $("#password").val().trim();
  if (password === "") {
    valid = false;
    $("#password").css("borderColor", "red");
    $("#password-error").text("Please enter Password");
  } else if (password.length < 8) {
    valid = false;
    $("#password").css("borderColor", "red");
    $("#password-error").text("Password must be at least 8 characters long");
  }

  var confirmPassword = $("#confirmPassword").val().trim();
  if (confirmPassword === "") {
    valid = false;
    $("#confirmPassword").css("borderColor", "red");
    $("#confirmPassword-error").text("Please confirm Password");
  } else if (confirmPassword !== password) {
    valid = false;
    $("#confirmPassword").css("borderColor", "red");
    $("#confirmPassword-error").text("Passwords do not match");
  }

  var photo = $("#photo").val().trim();
  if (photo === "") {
    valid = false;
    $("#photo").css("borderColor", "red");
    $("#photo-error").text("Please upload an image");
  } else {
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
    if (!allowedExtensions.exec(photo)) {
      valid = false;
      $("#photo").css("borderColor", "red");
      $("#photo-error").text(
        "Please upload a valid image file (jpg, jpeg, png)"
      );
    }
  }

  if (valid) {
    $("#userform").submit();
    $("#yourModalId").modal("hide");
    // location.reload();
  }
});

function validateEmail(email) {
  var re = /\S+@\S+\.\S+/;
  return re.test(email);
}

$(document).ready(function () {
  $("#logoutBtn").click(function () {
    var rememberedEmail = getCookie("remember_email");
    var rememberedPassword = getCookie("remember_password");

    if (rememberedEmail && rememberedPassword) {
      $("#exampleInputEmail1").val(rememberedEmail);
      $("#exampleInputPassword1").val(rememberedPassword);
    } 
  });
});
function getCookie(name) {
  var cookies = document.cookie.split(";");
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i].trim();
    if (cookie.indexOf(name + "=") === 0) {
      return cookie.substring(name.length + 1);
    }
  }
  return "";
}
