
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- exercise_name
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `exercise_name`;

CREATE TABLE `exercise_name`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `muscle_group` TINYINT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- exercise
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `exercise`;

CREATE TABLE `exercise`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `ex_name_id` INTEGER NOT NULL,
    `ex_name_s2_id` INTEGER,
    `ex_name_s3_id` INTEGER,
    `day` TINYINT NOT NULL,
    `kind` TINYINT NOT NULL,
    `serie` TINYINT NOT NULL,
    `repetition` VARCHAR(30) NOT NULL,
    `difficulty` INTEGER(1) DEFAULT 3 NOT NULL,
    `exec_weights` VARCHAR(90),
    `exec_times` VARCHAR(90),
    `pause_times` VARCHAR(90),
    `schedule_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `exercise_fi_1f0200` (`ex_name_id`),
    INDEX `exercise_fi_e9564c` (`ex_name_s2_id`),
    INDEX `exercise_fi_e6cda0` (`ex_name_s3_id`),
    INDEX `exercise_fi_5a9abb` (`schedule_id`),
    CONSTRAINT `exercise_fk_1f0200`
        FOREIGN KEY (`ex_name_id`)
        REFERENCES `exercise_name` (`id`),
    CONSTRAINT `exercise_fk_e9564c`
        FOREIGN KEY (`ex_name_s2_id`)
        REFERENCES `exercise_name` (`id`),
    CONSTRAINT `exercise_fk_e6cda0`
        FOREIGN KEY (`ex_name_s3_id`)
        REFERENCES `exercise_name` (`id`),
    CONSTRAINT `exercise_fk_5a9abb`
        FOREIGN KEY (`schedule_id`)
        REFERENCES `schedule` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- schedule
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `schedule`;

CREATE TABLE `schedule`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `from` DATE,
    `to` DATE,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
