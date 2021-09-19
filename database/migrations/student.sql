-- Doreen -- 
Create Table Student (
	ID int NOT NULL AUTO INCREMENT,
	LastName varchar (255) NOT NULL,
	FirstName varchar (255) NOT NULL,
	StreetAddress varchar (255) NOT NULL,
	City varchar (255) NOT NULL
	primary ?
);

-- Asandiswa ---
Create Table Student (
	ID int NOT NULL ,
	LastName varchar (255) NOT NULL,
	FirstName varchar (255) NOT NULL,
	StreetAddress varchar (255) NOT NULL,
	City varchar (255) NOT NULL,
	PRIMARY KEY (ID)
);

-- Olwethu --
Create Table Students (
	ID int NOT NULL AUTO INCREMENT,
	LastName varchar (255) NOT NULL,
	FirstName varchar (255) NOT NULL,
	StreetAddress varchar (255) NOT NULL,
	City varchar (255) NOT NULL
):

Create Table Course (
	ID int NOT NULL AUTO INCREMENT,
	CourseName varchar (255) NOT NULL
	????
	primary?
	course & college? - 
	course & student?
);

Create Table College (
	ID int NOT NULL AUTO INCREMENT,
	CollegeName varchar (255) NOT NULL,
	PRIMARY KEY (ID),
	FOREIGN KEY (CourseName) REFERENCES CourseName
); 


