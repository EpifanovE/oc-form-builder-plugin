<?php
return [
    'plugin' => [
        'name' => 'Конструктор форм',
        'description' => 'Управление формами на сайте.',
    ],
    'components' => [
        'form' => [
            'name' => 'Форма',
            'desc' => 'Показывает указанную форму',
        ]
    ],
    'form' => 'Форма',
    'params' => 'Параметры',
    'adv_class' => 'Дополнительные CSS-классы',
    'notification' => [
        'form_submit_subject' => 'Отправка формы на сайте',
        'form_submit_desc' => 'Отправка формы на сайте',
    ],
    'submit' => 'Отправить',
    'messages' => [
        'success' => 'Ваше сообщение успешно отправлено.',
        'error' => 'При отправке возникла ошибка. Пожалуйста повторите.',
    ],
    'recaptcha_is_not_defined' => 'Настройки для поля reCaptcha не заданы.',
    'form_not_defined' => 'Форма не задана.',
];