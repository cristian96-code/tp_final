
CREATE TABLE teatro(
	idteatro int(20) NOT NULL AUTO_INCREMENT,
        nombre varchar(30),
        direccion varchar(50),
PRIMARY KEY(idteatro,nombre)
)ENGINE=InnoDB default character set=utf8 auto_increment=1;

CREATE TABLE funcion(
	idfuncion int NOT NULL AUTO_INCREMENT,
        nombre varchar(30),
        horainicio varchar(30),
        duracion int(3) UNSIGNED,
        precio int(5) UNSIGNED,
        idteatro int(20),
PRIMARY KEY(idfuncion),
FOREIGN KEY(idteatro) REFERENCES teatro(idteatro) 
ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB default character set=utf8 auto_increment=1;

CREATE TABLE funteatro(
	idfuncion int,
PRIMARY KEY(idfuncion),
FOREIGN KEY(idfuncion) REFERENCES funcion(idfuncion)
ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB default character set=utf8 ;

CREATE TABLE funmusical(
	idfuncion int,
        director varchar(30),
        cantactores int(20),
PRIMARY KEY(idfuncion),
FOREIGN KEY(idfuncion) REFERENCES funcion(idfuncion)
ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB default character set=utf8;

CREATE TABLE funcine(
	idfuncion int,
        genero varchar(20),
        pais varchar(20),
PRIMARY KEY(idfuncion),
FOREIGN KEY(idfuncion) REFERENCES funcion(idfuncion)
ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=InnoDB default character set=utf8;
