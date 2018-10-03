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
  contactInfo   CHAR(255)   DEFAULT NULL,

  PRIMARY KEY (id),
  UNIQUE INDEX (email)
);

/** Таблица категорий (проектов). */
CREATE TABLE categories (
  id         INT         AUTO_INCREMENT,
  name       CHAR(255)   NOT NULL,
  creatorID  INT         NOT NULL,

  PRIMARY KEY (id),
  INDEX (creatorID)
);

/** Таблица задач. */
CREATE TABLE tasks (
  id              INT          AUTO_INCREMENT,
  name            CHAR(255)    NOT NULL,
  categoryID      INT          NOT NULL,
  creation        DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  deadline        DATETIME     DEFAULT NULL,
  attachmentPath  CHAR(255)    DEFAULT NULL,
  isComplete      TINYINT(1)   NOT NULL DEFAULT 0, -- 1 || 0 (true || false)

  PRIMARY KEY (id),
  INDEX (deadline),
  INDEX (categoryID)
);
