$("#formLogin").validate(
{
    submitHandler: function (form)
    {
        boxLoad('open');
        const formData = $(form).serializeObject();

        HTTP.post(cUrl('login/auth'), formData, '', (error, response) =>
        {
            boxLoad('close');
            if (error)
            {
                console.error(error);
                showNotify('danger', 'Houve um erro ao enviar os dados de login!');
            }
            else
            {
                if(response.redirect)
                    window.location.href = response.redirect.url;

                if(response.status)
                    showNotify(response.status.type, response.status.message);

                $(form)[0].reset();
            }
        });
        return false;
    }
});

jQuery.extend(jQuery.validator.messages, {
    required: "Este campo é requerido.",
    email: "Por favor, forneça um e-mail válido.",
});