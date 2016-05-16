/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     5/16/2016 9:55:31 AM                         */
/*==============================================================*/


drop table if exists Artical;

drop table if exists ArticalFeedback;

drop table if exists Book;

drop table if exists BookFeedback;

drop table if exists BorrowedRecord;

drop table if exists Config;

drop table if exists Log;

drop table if exists Session;

drop table if exists User;

/*==============================================================*/
/* Table: Artical                                               */
/*==============================================================*/
create table Artical
(
   id_artical           int not null,
   title                varchar(100),
   date                 datetime,
   content              text,
   status               int,
   id_user              int,
   primary key (id_artical)
);

/*==============================================================*/
/* Table: ArticalFeedback                                       */
/*==============================================================*/
create table ArticalFeedback
(
   id                   int not null,
   id_user              int,
   id_artical           int,
   date                 datetime,
   star                 int,
   feedback             varchar(300),
   status               int,
   primary key (id)
);

/*==============================================================*/
/* Table: Book                                                  */
/*==============================================================*/
create table Book
(
   id_book              int not null,
   type                 varchar(100),
   sub_type             varchar(100),
   name                 varchar(300),
   thumb_image          varchar(100),
   big_image            varchar(100),
   id_user              int,
   description          varchar(300),
   pledge               int,
   pledgeExpireTime     datetime,
   whoWantBook          int,
   pledged              boolean,
   status               int,
   primary key (id_book)
);

/*==============================================================*/
/* Table: BookFeedback                                          */
/*==============================================================*/
create table BookFeedback
(
   id                   int not null,
   id_book_borrowed     int,
   id_user              int,
   date                 datetime,
   star                 int,
   feedback             varchar(300),
   status               int,
   primary key (id)
);

/*==============================================================*/
/* Table: BorrowedRecord                                        */
/*==============================================================*/
create table BorrowedRecord
(
   id_book_borrowd      int not null,
   id_user              int,
   id_book              int,
   borrow_date          datetime,
   borrow_days          int,
   return_date          datetime,
   whoPayPledge         int,
   primary key (id_book_borrowd)
);

/*==============================================================*/
/* Table: Config                                                */
/*==============================================================*/
create table Config
(
   name                 varchar(500) not null,
   value                varchar(500),
   primary key (name)
);

/*==============================================================*/
/* Table: Log                                                   */
/*==============================================================*/
create table Log
(
   id                   int not null,
   id_user              int,
   date                 datetime,
   message              text,
   primary key (id)
);

/*==============================================================*/
/* Table: Session                                               */
/*==============================================================*/
create table Session
(
   id                   char(32) not null,
   name                 char(32) not null,
   modified             int,
   lifetime             int,
   data                 text,
   primary key (id, name)
);

/*==============================================================*/
/* Table: User                                                  */
/*==============================================================*/
create table User
(
   id_user              int not null,
   name                 varchar(32),
   type                 int,
   head_image           varchar(100),
   qq_number            varchar(10),
   mail                 varchar(100),
   status               int,
   primary key (id_user)
);

alter table Artical add constraint FK_Reference_4 foreign key (id_user)
      references User (id_user) on delete restrict on update restrict;

alter table ArticalFeedback add constraint FK_Reference_7 foreign key (id_user)
      references User (id_user) on delete restrict on update restrict;

alter table ArticalFeedback add constraint FK_Reference_8 foreign key (id_artical)
      references Artical (id_artical) on delete restrict on update restrict;

alter table Book add constraint FK_Reference_1 foreign key (id_user)
      references User (id_user) on delete restrict on update restrict;

alter table BookFeedback add constraint FK_Reference_5 foreign key (id_book_borrowed)
      references BorrowedRecord (id_book_borrowd) on delete restrict on update restrict;

alter table BookFeedback add constraint FK_Reference_6 foreign key (id_user)
      references User (id_user) on delete restrict on update restrict;

alter table BorrowedRecord add constraint FK_Reference_2 foreign key (id_book)
      references Book (id_book) on delete restrict on update restrict;

alter table BorrowedRecord add constraint FK_Reference_3 foreign key (id_user)
      references User (id_user) on delete restrict on update restrict;

alter table Log add constraint FK_Reference_9 foreign key (id_user)
      references User (id_user) on delete restrict on update restrict;

