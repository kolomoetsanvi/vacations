

--//////////////////////////////////////1. Создание БД///////////////////////////////


-- удаление базы данных
-- drop database if exists authorization_db;

-- создание базы данных и таблиц, задать кодировку и тип сортировки
create database if not exists  vacations_db charset utf8 collate utf8_general_ci;

use vacations_db;    -- БД vacations_db стала текущей


-- Создаем таблицу с ролями
create table if not exists roles (
	id         int primary key auto_increment,  
    role       varchar(255) not null       -- роль
)engine=InnoDB char set=UTF8;


-- Создаем таблицу Пользователей
create table if not exists users(
	id           int primary key auto_increment,
	username     varchar(255) not null,
	password     varchar(255) not null,
	auth_key     varchar(255),
    surname      varchar(255) not null,
    name         varchar(255) not null,
    patronymic   varchar(255),
    tab_nom      varchar(11) not null,  -- (т.к. могут существовать полные тески - совпадение по ФИО)
	role_id      int not null,
	FOREIGN KEY (role_Id ) REFERENCES roles (id)		     
)engine=InnoDB char set=UTF8;



-- Создаем таблицу с отпусками
create table if not exists vacations(
    id int primary key auto_increment,
    user_id            int      not null,
	created_at         datetime not null,
	updated_at         datetime not null,
	update_user_id     int,
    start_date         date     not null,                      -- дата начала отпуска
    end_date           date     not null,                      -- дата окончания отпуска
    confirmation       boolean  not null default false       -- пометка о подтверждении
 ) engine=InnoDB char set=UTF8;


--//////////////////////////////////////// 2. Заполняет БД данными ///////////////////////////////////////////
 use vacations_db;

insert into roles values
	(null, 'board'),
	(null, 'worker')
    ;

insert into users values
	   (null, 'user1', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Иванов', 'Иван', 'Иванович', '12345678912', 1), --password 12345678
	   (null, 'user2', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Петров', 'Петр', 'Петрович', '12345678913', 2), --password 12345678
	   (null, 'user3', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Сидорова', 'Елена', 'Семеновна', '12345678914', 2), --password 12345678
	   (null, 'user4', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Сергеев', 'Сергей', 'Сергеевич', '12345678915', 2), --password 12345678
	   (null, 'user5', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Антонова', 'Татьяна', 'Алексеевна', '12345678916', 2), --password 12345678
	   (null, 'user6', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Грибов', 'Сергей', 'Михайлович', '12345678917', 2), --password 12345678
	   (null, 'user7', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Соколова', 'Анна', 'Викторовна', '12345678918', 2), --password 12345678
	   (null, 'user8', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Николаев', 'Иван', 'Викторович', '12345678919', 2), --password 12345678
	   (null, 'user9', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Котов', 'Глеб', 'Валерьевич', '12345678921', 2), --password 12345678
	   (null, 'user10', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Тепличная', 'Оксана', 'Михайловна', '12345678922', 2), --password 12345678
	   (null, 'user11', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Смирнова', 'Татьяна', 'Григорьевна', '12345678923', 2), --password 12345678
	   (null, 'user12', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', null, 'Макаров', 'Петр', 'Иванович', '12345678924', 2) --password 12345678
       ;

insert into vacations values
(null, 2, '2020-10-05', '2020-10-05', null, '2020-07-01', '2020-07-08', false ),
(null, 3, '2020-10-05', '2020-10-05', null, '2020-07-15', '2020-07-29', false ),
(null, 4, '2020-10-05', '2020-10-05', 1, '2020-08-01', '2020-08-08', true ),
(null, 5, '2020-10-05', '2020-10-05', null, '2020-07-01', '2020-07-08', false ),
(null, 6, '2020-10-05', '2020-10-05', null, '2020-06-01', '2020-06-08', false ),
(null, 6, '2020-10-05', '2020-10-05', 1, '2020-07-01', '2020-07-08', true ),
(null, 7, '2020-10-05', '2020-10-05', null, '2020-06-10', '2020-06-24', false ),
(null, 8, '2020-10-05', '2020-10-05', null, '2020-07-01', '2020-07-08', false ),
(null, 8, '2020-10-05', '2020-10-05', null, '2020-09-21', '2020-10-28', false ),
(null, 9, '2020-10-05', '2020-10-05', 1, '2020-07-01', '2020-07-08', true )
;


