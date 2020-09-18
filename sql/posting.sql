CREATE TABLE posting_log (
	posting_log_id INT NOT NULL AUTO_INCREMENT,
	posting_log_time DATETIME,
	posting_log_remote_ip VARCHAR(20),
	posting_log_email VARCHAR(255),
	posting_log_filename VARCHAR(255),
	posting_log_json JSON NOT NULL,
	PRIMARY KEY(posting_log_id)
) ENGINE=InnoDB;

