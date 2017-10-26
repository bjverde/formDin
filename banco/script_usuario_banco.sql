DROP USER IF EXISTS 'form_exemplo'@'localhost';
CREATE USER 'form_exemplo'@'localhost' IDENTIFIED BY '123456';
GRANT DELETE,EXECUTE,INSERT,SELECT,UPDATE ON form_exemplo.* TO 'form_exemplo'@'localhost';