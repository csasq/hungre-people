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

-- TODO(отправить на почту)
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

-- TODO(отправить на почту)
create table feedback (
    id              bigint                  not null auto_increment,
    name            character varying (32)  not null,
    email_address   character varying (320) not null,
    phone_number    character varying (16)  not null,
    message         character varying (256) not null,
    created_at      timestamp               default now() not null,
    primary key (id)
);
