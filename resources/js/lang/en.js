export default {
    "en": {
        "passwords": {
            "password": "Passwords must be at least six characters and match the confirmation.",
            "reset": "Your password has been reset!",
            "sent": "We have e-mailed your password reset link!",
            "token": "This password reset token is invalid.",
            "user": "We can't find a user with that e-mail address."
        },
        "pagination": {
            "previous": "&laquo; Previous",
            "next": "Next &raquo;"
        },
        "common": {
            "mr": "Mr",
            "mrs": "Mrs",
            "company": "Company",
            "user_title_mr": "Mr",
            "user_title_mrs": "Mrs",
            "user_title_company": "Company",
            "tenant_title_mr": "Mr",
            "tenant_title_mrs": "Mrs",
            "tenant_title_company": "Company",
            "request_status_1": "Received",
            "request_status_2": "In Processing",
            "request_status_3": "Assigned",
            "request_status_4": "Done",
            "request_status_5": "Reactivated",
            "request_status_6": "Archived",
            "originalRequest_status_1": "Received",
            "originalRequest_status_2": "In Processing",
            "originalRequest_status_3": "Assigned",
            "originalRequest_status_4": "Done",
            "originalRequest_status_5": "Reactivated",
            "originalRequest_status_6": "Archived",
            "email_footer_message1": "This email was automatically generated for {UserName}.",
            "email_footer_message2": "You get this automatically generated e-mail as a user of {CompanyName}.",
            "email_link_contacts": "Contacts.",
            "email_link_terms_of_use": "Terms of Use",
            "email_link_data_protection": "Data protection"
        },
        "auth": {
            "failed": "These credentials do not match our records.",
            "throttle": "Too many login attempts. Please try again in {seconds} seconds."
        },
        "tenant": {
            "tenant_credentials": "Tenant credentials",
            "tenancy_details": "Tenancy details",
            "unit": "Unit",
            "floor": "Floor",
            "building": "Building",
            "address": "Address",
            "rent_start": "Rent start",
            "login_credentials": "Login credentials",
            "website": "Website",
            "username": "Username",
            "password": "Password",
            "url": "URL",
            "code": "Code"
        },
        "validation": {
            "accepted": "The {attribute} must be accepted.",
            "active_url": "The {attribute} is not a valid URL.",
            "after": "The {attribute} must be a date after {date}.",
            "after_or_equal": "The {attribute} must be a date after or equal to {date}.",
            "alpha": "The {attribute} may only contain letters.",
            "alpha_dash": "The {attribute} may only contain letters, numbers, dashes and underscores.",
            "alpha_num": "The {attribute} may only contain letters and numbers.",
            "array": "The {attribute} must be an array.",
            "before": "The {attribute} must be a date before {date}.",
            "before_or_equal": "The {attribute} must be a date before or equal to {date}.",
            "between": {
                "numeric": "The {attribute} must be between {min} and {max}.",
                "file": "The {attribute} must be between {min} and {max} kilobytes.",
                "string": "The {attribute} must be between {min} and {max} characters.",
                "array": "The {attribute} must have between {min} and {max} items."
            },
            "boolean": "The {attribute} field must be true or false.",
            "confirmed": "The {attribute} confirmation does not match.",
            "date": "The {attribute} is not a valid date.",
            "date_equals": "The {attribute} must be a date equal to {date}.",
            "date_format": "The {attribute} does not match the format {format}.",
            "different": "The {attribute} and {other} must be different.",
            "digits": "The {attribute} must be {digits} digits.",
            "digits_between": "The {attribute} must be between {min} and {max} digits.",
            "dimensions": "The {attribute} has invalid image dimensions.",
            "distinct": "The {attribute} field has a duplicate value.",
            "email": "The {attribute} must be a valid email address.",
            "exists": "The selected {attribute} is invalid.",
            "file": "The {attribute} must be a file.",
            "filled": "The {attribute} field must have a value.",
            "gt": {
                "numeric": "The {attribute} must be greater than {value}.",
                "file": "The {attribute} must be greater than {value} kilobytes.",
                "string": "The {attribute} must be greater than {value} characters.",
                "array": "The {attribute} must have more than {value} items."
            },
            "gte": {
                "numeric": "The {attribute} must be greater than or equal {value}.",
                "file": "The {attribute} must be greater than or equal {value} kilobytes.",
                "string": "The {attribute} must be greater than or equal {value} characters.",
                "array": "The {attribute} must have {value} items or more."
            },
            "image": "The {attribute} must be an image.",
            "in": "The selected {attribute} is invalid.",
            "in_array": "The {attribute} field does not exist in {other}.",
            "integer": "The {attribute} must be an integer.",
            "ip": "The {attribute} must be a valid IP address.",
            "ipv4": "The {attribute} must be a valid IPv4 address.",
            "ipv6": "The {attribute} must be a valid IPv6 address.",
            "json": "The {attribute} must be a valid JSON string.",
            "lt": {
                "numeric": "The {attribute} must be less than {value}.",
                "file": "The {attribute} must be less than {value} kilobytes.",
                "string": "The {attribute} must be less than {value} characters.",
                "array": "The {attribute} must have less than {value} items."
            },
            "lte": {
                "numeric": "The {attribute} must be less than or equal {value}.",
                "file": "The {attribute} must be less than or equal {value} kilobytes.",
                "string": "The {attribute} must be less than or equal {value} characters.",
                "array": "The {attribute} must not have more than {value} items."
            },
            "max": {
                "numeric": "The {attribute} may not be greater than {max}.",
                "file": "The {attribute} may not be greater than {max} kilobytes.",
                "string": "The {attribute} may not be greater than {max} characters.",
                "array": "The {attribute} may not have more than {max} items."
            },
            "mimes": "The {attribute} must be a file of type: {values}.",
            "mimetypes": "The {attribute} must be a file of type: {values}.",
            "min": {
                "numeric": "The {attribute} must be at least {min}.",
                "file": "The {attribute} must be at least {min} kilobytes.",
                "string": "The {attribute} must be at least {min} characters.",
                "array": "The {attribute} must have at least {min} items."
            },
            "not_in": "The selected {attribute} is invalid.",
            "not_regex": "The {attribute} format is invalid.",
            "numeric": "The {attribute} must be a number.",
            "present": "The {attribute} field must be present.",
            "regex": "The {attribute} format is invalid.",
            "required": "The {attribute} field is required.",
            "required_if": "The {attribute} field is required when {other} is {value}.",
            "required_unless": "The {attribute} field is required unless {other} is in {values}.",
            "required_with": "The {attribute} field is required when {values} is present.",
            "required_with_all": "The {attribute} field is required when {values} are present.",
            "required_without": "The {attribute} field is required when {values} is not present.",
            "required_without_all": "The {attribute} field is required when none of {values} are present.",
            "same": "The {attribute} and {other} must match.",
            "size": {
                "numeric": "The {attribute} must be {size}.",
                "file": "The {attribute} must be {size} kilobytes.",
                "string": "The {attribute} must be {size} characters.",
                "array": "The {attribute} must contain {size} items."
            },
            "starts_with": "The {attribute} must start with one of the following: {values}",
            "string": "The {attribute} must be a string.",
            "timezone": "The {attribute} must be a valid zone.",
            "unique": "The {attribute} has already been taken.",
            "uploaded": "The {attribute} failed to upload.",
            "url": "The {attribute} format is invalid.",
            "uuid": "The {attribute} must be a valid UUID.",
            "custom": {
                "attribute-name": {
                    "rule-name": "custom-message"
                }
            },
            "attributes": []
        }
    }
}
