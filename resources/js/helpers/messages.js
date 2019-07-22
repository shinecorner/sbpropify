import Vue from '@/app';


export const errorMessage = async (defaultMessage, status, err = {}) => {
    let message = {
        message: defaultMessage,
        success: false
    };

    if (status != 401) {
        message.message = 'server_error';
    }
    if (status == 422) {
        message.message = 'validation_error';
        message.status = 422;
        message.error = err;
    }

    if (status == 404) {
        message.message = defaultMessage;
    }

    if (status == 401) {
        const {$store} = await Vue;

        $store.dispatch("forceLogout");
    }

    return message;
};

export const displayError = async (err) => {
    const {$swal, $i18n} = await Vue;

    if (err && err.message) {
        if (err.status && err.error) {
            _.each(err.error.response.data.errors, (errorObj) => {
                if (_.isArray(errorObj)) {
                    _.each(errorObj, (er) => {
                        $swal({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            type: 'error',
                            title: $i18n.t(er)
                        });
                    })
                }
            });
        } else {
            const msg = err.message;
            $swal({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                type: 'error',
                title: $i18n.t(typeof msg === 'string' ? msg : (typeof msg === 'object' ? msg[Object.keys(msg)[0]][0] : 'ERROR'))
            });
        }

    }
};

export const displaySuccess = async (resp) => {
    if (resp && resp.message) {
        const {$i18n, $swal, $router} = await Vue;

        /*$swal({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            type: 'success',
            title: $i18n.t(resp.message)
        });*/

        const toggleModal = () =>{
            $swal.fire(
                {
                    title: '',
                    text: $i18n.t(resp.message),
                    type: 'success',
                    showConfirmButton: false
                },
            );

            setTimeout(()=> {
                $swal.close();
            }, 900);
        };

        toggleModal();


        if (resp.redirect) {
            $router.push({name: resp.redirect});
        }
    }
};

export default {
    errorMessage
}
