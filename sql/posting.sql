CREATE TABLE posting_log (
	id INT NOT NULL AUTO_INCREMENT,
	time_access DATETIME,
	remote_ip VARCHAR(20),
	email VARCHAR(255),
	filename VARCHAR(255),
	useragent VARCHAR(255),
	json JSON NOT NULL,
	success BOOLEAN,
	PRIMARY KEY(id),
	UNIQUE KEY (time_access,remote_ip,email,filename)
) ENGINE=InnoDB;

