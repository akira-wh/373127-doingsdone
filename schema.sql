/** Создание базы данных, активация. */
CREATE DATABASE doingsdone
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

/** Таблица пользователей. */
CREATE TABLE users (
  id            INT         AUTO_INCREMENT,
  name          CHAR(64)    NOT NULL,
  email         CHAR(64)    NOT NULL,
  password      CHAR(255)   NOT NULL,
  registration  DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  contact_info  CHAR(255)   DEFAULT NULL,

  PRIMARY KEY (id),
  UNIQUE INDEX (email)
);

/** Таблица категорий (проектов). */
CREATE TABLE categories (
  id          INT         AUTO_INCREMENT,
  name        CHAR(255)   NOT NULL,
  creator_id  INT         NOT NULL,

  PRIMARY KEY (id),
  INDEX (creator_id)
);

/** Таблица задач. */
CREATE TABLE tasks (
  id                   INT          AUTO_INCREMENT,
  name                 CHAR(255)    NOT NULL,
  category_id          INT          DEFAULT NULL,
  creator_id           INT          NOT NULL,
  creation             DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  deadline             DATETIME     DEFAULT NULL,
  attachment_label     CHAR(255)    DEFAULT NULL,
  attachment_filename  CHAR(255)    DEFAULT NULL,
  is_complete          TINYINT(1)   NOT NULL DEFAULT 0, -- 1 || 0 (true || false)

  PRIMARY KEY (id),
  INDEX (category_id),
  INDEX (creator_id),
  INDEX (deadline)
);
