CREATE TABLE `nw202201`.`intentospagos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATETIME NOT NULL,
  `cliente` VARCHAR(128) NOT NULL,
  `monto` DOUBLE NOT NULL,
  `fechaVencimiento` VARCHAR(45) NOT NULL,
  `estado` CHAR(3) NOT NULL,
  PRIMARY KEY (`id`));