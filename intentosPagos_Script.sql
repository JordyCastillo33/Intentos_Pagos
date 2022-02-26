USE `nw202201` ;
CREATE TABLE `nw202201`.`intentospagos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATETIME NOT NULL,
  `cliente` VARCHAR(128) NOT NULL,
  `monto` DECIMAL(13,2) NOT NULL,
  `fechaVencimiento` DATE NOT NULL,
  `estado` CHAR(3) NOT NULL,
  PRIMARY KEY (`id`));