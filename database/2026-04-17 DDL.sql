create table accounts
(
    id          int unsigned auto_increment
        primary key,
    first_name  varchar(255) null,
    last_name   varchar(255) null,
    activated   tinyint(1)   null,
    email       varchar(255) null,
    langKey     varchar(20)  null,
    city_id     int          null,
    gender      varchar(255) null,
    image_url   varchar(255) null,
    user_id     int          null,
    deleted_at  timestamp    null,
    dni         varchar(50)  null,
    created_at  timestamp    null,
    updated_at  timestamp    null,
    address     varchar(255) null,
    phone       varchar(255) null,
    birthday    timestamp    null,
    account_cod varchar(150) null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table authorities
(
    id        int auto_increment
        primary key,
    user_id   int         null,
    authority varchar(30) null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table bank_accounts
(
    id         bigint unsigned auto_increment
        primary key,
    store_id   int          not null,
    bank       varchar(125) not null,
    cbu        varchar(125) not null,
    cvu        varchar(125) not null,
    alias      varchar(125) not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    deleted_at timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table categories
(
    id          bigint unsigned auto_increment
        primary key,
    name        varchar(255) not null,
    description varchar(255) null,
    category_id varchar(255) null,
    color       varchar(255) null,
    created_at  timestamp    null,
    updated_at  timestamp    null,
    deleted_at  timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table cities
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255) not null,
    state      varchar(255) not null,
    country    varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    deleted_at timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table coupons
(
    id             bigint unsigned auto_increment
        primary key,
    store_id       int          not null,
    code           varchar(255) not null,
    description    varchar(255) not null,
    limit_discount double       not null,
    category_id    int          not null,
    discount       double       not null,
    date_to        date         not null,
    state          varchar(255) not null,
    created_at     timestamp    null,
    updated_at     timestamp    null,
    deleted_at     timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table customers
(
    id          bigint unsigned auto_increment
        primary key,
    name        varchar(255) not null,
    dni         varchar(255) null,
    birthday    date         null,
    email       varchar(255) not null,
    address     varchar(255) null,
    token       varchar(255) null,
    password    varchar(255) null,
    city_id     int          null,
    is_provider tinyint(1)   null,
    created_at  timestamp    null,
    updated_at  timestamp    null,
    deleted_at  timestamp    null,
    phone       varchar(30)  null,
    store_id    int          null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table discounts
(
    id             bigint unsigned auto_increment
        primary key,
    store_id       int          not null,
    date_from      date         not null,
    date_to        date         not null,
    description    varchar(255) not null,
    limit_discount double       not null,
    category_id    int          not null,
    product_id     int          not null,
    discount       double       not null,
    active         tinyint(1)   not null,
    created_at     timestamp    null,
    updated_at     timestamp    null,
    deleted_at     timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table failed_jobs
(
    id         bigint unsigned auto_increment
        primary key,
    uuid       varchar(255)                        not null,
    connection text                                not null,
    queue      text                                not null,
    payload    longtext                            not null,
    exception  longtext                            not null,
    failed_at  timestamp default CURRENT_TIMESTAMP not null,
    constraint failed_jobs_uuid_unique
        unique (uuid)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table images
(
    id         int auto_increment
        primary key,
    title      varchar(500) null,
    `primary`  tinyint(1)   null,
    benefit_id int          null,
    store_id   int          null,
    product_id int          null,
    event_id   int          null,
    src        varchar(150) null,
    updated_at timestamp    null,
    deleted_at timestamp    null,
    created_at timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table movements
(
    id          bigint unsigned auto_increment
        primary key,
    date        date         not null,
    sale_id     int          null,
    customer_id int          null,
    account_id  int          null,
    provider_id int          null,
    concept     varchar(255) not null,
    amount      double       not null,
    type        varchar(255) not null,
    state       varchar(255) not null,
    user        varchar(255) not null,
    created_at  timestamp    null,
    updated_at  timestamp    null,
    deleted_at  timestamp    null,
    store_id    int          null,
    pay_id      int          null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table password_resets
(
    email      varchar(255) not null,
    token      varchar(255) not null,
    created_at timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create index password_resets_email_index
    on password_resets (email);

create table payment_items
(
    id         bigint unsigned auto_increment
        primary key,
    payment_id int          not null,
    concept    varchar(255) not null,
    amount     double       not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    deleted_at timestamp    null,
    date       timestamp    null,
    paid       tinyint(1)   null,
    ref_id     int          null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table payment_states
(
    id          int auto_increment
        primary key,
    name        varchar(50) null,
    description text        null
)
    collate = utf8mb4_0900_ai_ci;

create table payments
(
    id               bigint unsigned auto_increment
        primary key,
    pay_date         date         not null,
    sale_id          int          not null,
    note             varchar(255) null,
    amount           double       not null,
    discount         double       null,
    total            double       null,
    coupon_code      varchar(255) null,
    payment_type_id  int          null,
    payment_state_id int          not null,
    user_id          int          not null,
    created_at       timestamp    null,
    updated_at       timestamp    null,
    deleted_at       timestamp    null,
    pay_method       varchar(30)  null,
    pay_ref          varchar(50)  null,
    store_id         int          null,
    bank_account_id  int          null,
    user             varchar(100) null,
    concept          varchar(255) null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table personal_access_tokens
(
    id             bigint unsigned auto_increment
        primary key,
    tokenable_type varchar(255)    not null,
    tokenable_id   bigint unsigned not null,
    name           varchar(255)    not null,
    token          varchar(64)     not null,
    abilities      text            null,
    last_used_at   timestamp       null,
    created_at     timestamp       null,
    updated_at     timestamp       null,
    constraint personal_access_tokens_token_unique
        unique (token)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create index personal_access_tokens_tokenable_type_tokenable_id_index
    on personal_access_tokens (tokenable_type, tokenable_id);

create table product_states
(
    id         int auto_increment
        primary key,
    name       varchar(50) null,
    created_at timestamp   null,
    deleted_at timestamp   null,
    updated_at timestamp   null,
    color      varchar(50) null
)
    engine = InnoDB;

create table products
(
    id          bigint unsigned auto_increment
        primary key,
    title       varchar(200) null,
    code        varchar(255) not null,
    description varchar(255) null,
    store_id    int          not null,
    provider_id int          null,
    category_id int          not null,
    state_id    int          null,
    color       varchar(255) null,
    size        int          null,
    price       double       null,
    cost        double       null,
    created_at  timestamp    null,
    updated_at  timestamp    null,
    deleted_at  timestamp    null,
    fee         int          null,
    brand       varchar(150) null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table providers
(
    id           bigint unsigned auto_increment
        primary key,
    name         varchar(255) not null,
    cuil         varchar(255) null,
    contact_name varchar(255) null,
    email        varchar(255) not null,
    phone        varchar(255) null,
    address      varchar(255) null,
    token        varchar(255) null,
    password     varchar(255) null,
    city_id      int          null,
    created_at   timestamp    null,
    updated_at   timestamp    null,
    deleted_at   timestamp    null,
    fee          int          null,
    alias        varchar(150) null,
    bank         varchar(150) null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table sale_states
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255) not null,
    color      varchar(255) null,
    created_at timestamp    null,
    updated_at timestamp    null,
    deleted_at timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table sale_statuses
(
    id         bigint unsigned auto_increment
        primary key,
    event      varchar(50)  null,
    note       varchar(255) null,
    date_from  timestamp    not null,
    date_to    timestamp    null,
    sale_id    int          not null,
    state_id   int          not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    deleted_at timestamp    null,
    user_email varchar(200) null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table sales
(
    id              bigint unsigned auto_increment
        primary key,
    store_id        int          not null,
    customer_id     int          null,
    sale_state_id   int          not null,
    date_sale       date         null,
    date_pay        date         null,
    note            varchar(255) null,
    total_price     int          not null,
    coupon_code     varchar(255) null,
    days_to_confirm int          null,
    days_to_cancel  int          null,
    created_at      timestamp    null,
    updated_at      timestamp    null,
    deleted_at      timestamp    null,
    user            varchar(50)  null,
    code            varchar(100) null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table sales_codes
(
    id         int auto_increment
        primary key,
    year       int          null,
    h_id       int          null,
    sec        int          null,
    code       varchar(150) null,
    updated_at timestamp    null,
    created_at timestamp    null
)
    engine = InnoDB;

create table settlement_details
(
    id                bigint unsigned auto_increment
        primary key,
    settlement_id     bigint unsigned not null,
    sale_item_id      bigint unsigned not null,
    sale_amount       decimal(12, 2)  not null,
    product_fee       decimal(5, 2)   not null,
    calculated_amount decimal(12, 2)  not null,
    created_at        timestamp       null,
    updated_at        timestamp       null,
    constraint settlement_details_settlement_id_sale_item_id_unique
        unique (settlement_id, sale_item_id)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create index settlement_details_sale_item_id_foreign
    on settlement_details (sale_item_id);

create index settlement_details_settlement_id_index
    on settlement_details (settlement_id);

create table settlements
(
    id            bigint unsigned auto_increment
        primary key,
    provider_id   bigint unsigned                                                 not null,
    start_date    date                                                            not null,
    end_date      date                                                            not null,
    total_sales   decimal(12, 2)                                                  not null,
    amount_to_pay decimal(12, 2)                                                  not null,
    status        enum ('pending', 'paid', 'cancelled') default 'pending'         not null,
    generated_at  timestamp                             default CURRENT_TIMESTAMP not null,
    generated_by  bigint unsigned                                                 null,
    paid_at       timestamp                                                       null,
    paid_by       bigint unsigned                                                 null,
    cancelled_at  timestamp                                                       null,
    cancelled_by  bigint unsigned                                                 null,
    created_at    timestamp                                                       null,
    updated_at    timestamp                                                       null,
    store_id      int                                                             null,
    user          varchar(200)                                                    null,
    items_count   int                                                             null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table sale_items
(
    id            bigint unsigned auto_increment
        primary key,
    sale_id       int                  not null,
    product_id    int                  not null,
    price         double               not null,
    settled       tinyint(1) default 0 not null,
    settlement_id bigint unsigned      null,
    deleted_at    timestamp            null,
    status        varchar(100)         null,
    quantity      int                  null,
    updated_at    timestamp            null,
    constraint sale_items_settlement_id_foreign
        foreign key (settlement_id) references settlements (id)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create index settlements_cancelled_by_foreign
    on settlements (cancelled_by);

create index settlements_generated_at_index
    on settlements (generated_at);

create index settlements_generated_by_foreign
    on settlements (generated_by);

create index settlements_paid_by_foreign
    on settlements (paid_by);

create index settlements_provider_id_index
    on settlements (provider_id);

create index settlements_status_index
    on settlements (status);

create table store_discounts
(
    id          bigint unsigned auto_increment
        primary key,
    sale_id     int          not null,
    discount_id int          not null,
    description varchar(255) not null,
    discount    double       not null,
    created_at  timestamp    null,
    updated_at  timestamp    null,
    deleted_at  timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table stores
(
    id          bigint unsigned auto_increment
        primary key,
    name        varchar(255) not null,
    email       varchar(255) not null,
    address     varchar(255) null,
    latitud     double       null,
    longitud    double       null,
    city_id     int          not null,
    owner_id    int          not null,
    facebook    varchar(255) null,
    instagram   varchar(255) null,
    phone       varchar(255) null,
    state       varchar(255) null,
    logo        varchar(255) null,
    description text         null,
    created_at  timestamp    null,
    updated_at  timestamp    null,
    deleted_at  timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table user_store
(
    id         int unsigned auto_increment
        primary key,
    user_id    int          not null,
    store_id   int          not null,
    role       varchar(255) not null,
    active     tinyint(1)   not null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

create table users
(
    id                bigint unsigned auto_increment
        primary key,
    name              varchar(255) not null,
    email             varchar(255) not null,
    email_verified_at timestamp    null,
    password          varchar(255) not null,
    logins            int          null,
    remember_token    varchar(100) null,
    created_at        timestamp    null,
    updated_at        timestamp    null,
    google_id         varchar(50)  null,
    role              varchar(50)  null,
    constraint users_email_unique
        unique (email)
)
    engine = InnoDB
    collate = utf8mb4_unicode_ci;

