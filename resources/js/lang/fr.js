import frLocale from 'element-ui/lib/locale/lang/fr';

export default  {
    ...frLocale,
    en: 'EN',
    fr: 'FR',
    it: 'IT',
    de: 'DE',
    unauthenticated: 'Unauthenticated',
    logged_out: 'Logged out',
    logged_in: 'Logged in',
    invalid_credentials: 'Invalid Credentials',
    server_error: 'Server error',
    reset_password: 'Reset Password',
    reset_password_mail: 'Send reset password mail',
    back_to_login: 'Go back to login',
    forgot_password: 'Forgot password',
    remember_me: 'Remember me',
    password: 'Password',
    confirm_password: 'Confirm password',
    password_validation: {
        required: "Password is required",
        confirm: 'Please input the password again',
        match: 'The passwords aren\'t equal'
    },
    email: 'Email',
    email_validation: {
        required: 'Email is required',
        email: 'Please enter a valid Email',
    },
    login: 'Login',
    menu: {
        dashboard: 'Dashboard',
        news: 'News',
        requests: 'Requests',
        marketplace: 'Marketplace',
        settings: 'Settings',
        logout: 'Logout',
        profile: 'Profile',
        users: 'Users',
        employees: 'Employees',
        companies: 'Companies',
        admins: 'Admins',
        home_owners: 'Home Owners',
        about: 'About',
        feedback: 'Feedback'
    },
    support: "Support",
    actions: {
        label: "Operations",
        edit: 'Edit',
        delete: 'Delete',
        create: 'Create',
        view: 'Details'
    },
    models: {
        user: {
            name: 'Name',
            phone: 'Phone',
            date: 'Date',
            email: 'Email',
            id: 'ID',
            add: 'Add user',
            save: 'Save',
            validation: {
                name: {
                    required: 'Name is required'
                },
                role: {
                    required: 'Role is required'
                }
            }
        }
    },
    swal: {
        delete: {
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            confirmText: 'Yes, delete it!',
            deleted: 'Deleted successfully'
        },
        add: {
            added: 'Added successfully'
        }
    },
    roles: {
        label: 'Role',
        administrator: 'Administrator',
        homeowner: 'Home Owner',
        manager: 'Manager',
        registered: 'Registered',
        service: 'Service',
        super_admin: 'Super Admin',
    },
    settings: {
        notifications: "Notifications and language",
        admin: 'Admin notifications',
        news: 'News notifications',
        service: 'Service notifications',
        updated: 'Settings updated'
    }
}