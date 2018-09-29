/** Создание базы данных, активация. */
CREATE DATABASE doingsdone
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

/** Таблица пользователей. */
CREATE TABLE users (
  id            INT AUTO_INCREMENT,
  name          CHAR(64),
  email         CHAR(64),
  password      CHAR(64),
  registration  DATETIME,
  contact_info  CHAR(255),

  PRIMARY KEY (id),

  UNIQUE INDEX (email)
);

/** Таблица категорий (проектов). */
CREATE TABLE categories (
  id          INT AUTO_INCREMENT,
  name        CHAR(255),
  creator_id  INT REFERENCES users(id),

  PRIMARY KEY (id),

  FOREIGN KEY (creator_id) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE CASCADE,

  INDEX (creator_id)
);

/** Таблица задач. */
CREATE TABLE tasks (
  id               INT AUTO_INCREMENT,
  name             CHAR(255),
  category_id      INT,
  creator_id       INT,
  creation         DATETIME,
  deadline         DATETIME,
  attachment_path  CHAR(255),
  is_complete      TINYINT(1), -- 1 || 0 (true || false)

  PRIMARY KEY (id),

  FOREIGN KEY (category_id) REFERENCES categories(id)
    ON UPDATE CASCADE ON DELETE CASCADE,

  FOREIGN KEY (creator_id) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE CASCADE,

  INDEX (deadline)
);
