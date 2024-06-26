create table users (
    id              bigint                  not null auto_increment,
    email_address   character varying (320) not null,
    password_hash   character varying (40)  not null,
    primary key (id),
    unique (email_address)
);

create table sessions (
    id              bigint                  not null auto_increment,
    user_id         bigint                  not null,
    access_token    binary (32)             not null,
    primary key (id),
    foreign key (user_id) references users (id)
);

create table static (
    id              bigint                  not null auto_increment,
    attributes      json                    not null,
    primary key (id)
);

create table bookings (
    id              bigint                  not null auto_increment,
    name            character varying (32)  not null,
    email_address   character varying (320) not null,
    phone_number    character varying (16)  not null,
    people_number   tinyint(1)              not null,
    datetime        datetime                not null,
    created_at      timestamp               default now() not null,
    primary key (id)
);

create table menu (
    id              bigint                  not null auto_increment,
    title           character varying (32)  not null,
    caption         character varying (64)  not null,
    prise           character varying (12)  not null,
    category        enum (
                        'soupe',
                        'pizza',
                        'pasta',
                        'desert',
                        'wine',
                        'beer',
                        'drinks'
                    )                       not null,
    priority        bit(1)                  not null,
    primary key (id)
);

create table feedback (
    id              bigint                  not null auto_increment,
    name            character varying (32)  not null,
    email_address   character varying (320) not null,
    phone_number    character varying (16)  not null,
    message         character varying (256) not null,
    created_at      timestamp               default now() not null,
    primary key (id)
);

insert into static (
    id,
    attributes
) values (
    1,
    '{"image": "images/about-img.png", "title": "about us", "caption": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis at velit maximus, molestie est a, tempor magna.", "description": "Integer ullamcorper neque eu purus euismod, ac faucibus mauris posuere. Morbi non ultrices ligula. Sed dictum, enim sed ullamcorper feugiat, dui odio vehicula eros, a sollicitudin lorem quam nec sem. Mauris tincidunt feugiat diam convallis pharetra. Nulla facilisis semper laoreet."}'
), (
    2,
    '{"image": "images/cook.png", "title": "master chef", "caption": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis at velit maximus, molestie est a, tempor magna.", "description": "Integer ullamcorper neque eu purus euismod, ac faucibus mauris posuere. Morbi non ultrices ligula. Sed dictum, enim sed ullamcorper feugiat, dui odio vehicula eros, a sollicitudin lorem quam nec sem. Mauris tincidunt feugiat diam convallis pharetra. Nulla facilisis semper laoreet."}'
), (
    3,
    '{"image": "images/pancakes-img.png", "title": "chocolate pancakes", "caption": "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis at velit maximus, molestie est a, tempor magna.", "description": "Integer ullamcorper neque eu purus euismod, ac faucibus mauris posuere. Morbi non ultrices ligula. Sed dictum, enim sed ullamcorper feugiat, dui odio vehicula eros, a sollicitudin lorem quam nec sem. Mauris tincidunt feugiat diam convallis pharetra. Nulla facilisis semper laoreet."}'
), (
    4,
    '{"image": "images/rings.png", "title": "weddings"}'
), (
    5,
    '{"image": "images/party.png", "title": "corporate parties"}'
);

insert into menu (
    title,
    caption,
    prise,
    category,
    priority
) values (
    'SOUPE QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'soupe',
    true
), (
    'SOUPE QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'soupe',
    true
), (
    'SOUPE QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'soupe',
    true
), (
    'SOUPE QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'soupe',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PIZZA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pizza',
    true
), (
    'PASTA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pasta',
    true
), (
    'PASTA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pasta',
    true
), (
    'PASTA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pasta',
    true
), (
    'PASTA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pasta',
    true
), (
    'PASTA QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'pasta',
    true
), (
    'DESERT QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'desert',
    true
), (
    'DESERT QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'desert',
    true
), (
    'DESERT QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'desert',
    true
), (
    'WINE QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'wine',
    true
), (
    'WINE QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'wine',
    true
), (
    'WINE QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'wine',
    true
), (
    'WINE QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'wine',
    true
), (
    'WINE QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'wine',
    true
), (
    'WINE QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'wine',
    true
), (
    'WINE QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'wine',
    true
), (
    'BEER QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'beer',
    true
), (
    'BEER QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'beer',
    true
), (
    'BEER QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'beer',
    true
), (
    'BEER QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'beer',
    true
), (
    'DRINKS QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'drinks',
    true
), (
    'DRINKS QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'drinks',
    true
), (
    'DRINKS QUATRO STAGIONI . . .',
    'Integer ullamcorper neque eu purus euismod',
    '55,68 USD',
    'drinks',
    true
);
