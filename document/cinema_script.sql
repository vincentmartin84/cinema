-- création script base de donnée basecinema

create database if not exists basecinema default character set utf8 collate utf8_general_ci;
use basecinema; 

set foreign_key_checks = 0;

-- création table film 

drop table if exists film;
create table film (
    fil_id int auto_increment primary key, 
    fil_nom varchar(500) not null,
    fil_date_sortie date not null,
    fil_affiche varchar(500) not null
)engine=innodb; 

-- création table individu 

drop table if exists individu;
create table individu (
    ind_id int auto_increment primary key,
    ind_nom varchar(500) not null,
    ind_prenom varchar(500) not null
)engine=innodb; 

-- création table cinema 

drop table if exists cinema;
create table cinema (
    cin_id int auto_increment primary key,    
    cin_nom varchar(500) not null, 
    cin_ville varchar(500) not null    
)engine=innodb; 

-- création table participer 

drop table if exists participer;
create table participer (
    par_id int auto_increment primary key,
    par_fonction varchar(500) not null,    
    par_individu int not null, 
    par_film int not null
)engine=innodb; 

-- création table projeter 
drop table if exists projeter;
create table projeter (
    pro_id int auto_increment primary key,
    pro_date_debut date not null,    
    pro_date_fin date not null,    
    pro_cinema int not null, 
    pro_film int not null
)engine=innodb; 

set foreign_key_checks =1;

-- contraintes d'intrégritées 

alter table participer add constraint cs1 foreign key (par_individu) references individu(ind_id) on delete cascade;
alter table participer add constraint cs2 foreign key (par_film) references film(fil_id) on delete cascade;
alter table projeter add constraint cs3 foreign key (pro_cinema) references cinema(cin_id) on delete cascade;
alter table projeter add constraint cs4 foreign key (pro_film) references film(fil_id) on delete cascade;
