$(document).ready(function () {
    $('#registration-form').submit(function (event) {
        event.preventDefault();

        var studentid = $(this).find('input[name="student_ID"]').val();
        var email = $(this).find('input[name="student_email"]').val();
        var password = $(this).find('input[name="student_password"]').val();
        var confirmPassword = $(this).find('input[name="confirm_password"]').val();
        var errors = [];

        if (!isValidStudentID(studentid)) {
            errors.push('Invalid Student ID.');
            $('#error-studentid').text('Invalid Student ID.');
            $(this).find('input[name="student_ID"]').addClass('error-border');
        } else {
            $('#error-studentid').text('');
            $(this).find('input[name="student_ID"]').removeClass('error-border');
        }

        if (!isValidPassword(password)) {
            errors.push('Password must be minimum of 8 characters.');
            $('#error-pw').text('Password must be minimum of 8 characters.');
            $(this).find('input[name="student_password"]').addClass('error-border');
            $(this).find('input[name="confirm_password"]').addClass('error-border');
        } else if(password !== confirmPassword){
            errors.push('Passwords do not match.');
            $('#error-pw').text('Passwords do not match.');
            $(this).find('input[name="student_password"]').addClass('error-border');
            $(this).find('input[name="confirm_password"]').addClass('error-border');
        }else{
            $('#error-pw').text('');
            $(this).find('input[name="student_password"]').removeClass('error-border');
            $(this).find('input[name="confirm_password"]').removeClass('error-border');
        }

        if (!isValidEmail(email)) {
            errors.push('Invalid email.');
            $('#error-email').text('Invalid email.');
            $(this).find('input[name="student_email"]').addClass('error-border');
        } else {
            $('#error-email').text('');
            $(this).find('input[name="student_email"]').removeClass('error-border');

            // Additional AJAX request to check email existence
            $.ajax({
                type: 'POST',
                url: 'check-email.php',
                data: { email: email },
                success: function (response) {
                    if (response === 'exists') {
                        errors.push('Email already exists.');
                        $('#error-email').text('Email already exists.');
                        $(this).find('input[name="student_email"]').addClass('error-border');
                    }
                    if (errors.length === 0 && response !== 'exists') {
                        $('#registration-form')[0].submit();
                    }
                }.bind(this) // Ensure the correct scope inside the AJAX success function
            });
        }
    });

    function isValidStudentID(studentid) {
        // var studentidRegex = /^(19|20|21|22|23|24)-[uU][rR]-\d{4}$/;
        var studentidRegex = /^(19|20|21|22|23|24)-[a-zA-Z][a-zA-Z]-\d{4}$/;
        return studentidRegex.test(studentid);
    }

    function isValidEmail(email) {
        var emailRegex = /@psu\.edu\.ph$/; // Email should end with "@psu.edu.ph"
        return emailRegex.test(email);
    }

    function isValidPassword(password) {
        return password.length >= 8;
    }
});
