CREATE TABLE files (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name NOT NULL,  
  filename NOT NULL,
  location NOT NULL,
  count INTEGER
);

insert into files(name, filename, location, count) values ('Android app', 'schaeffler-android.apk', './uploads/android.apk', 0);
insert into files(name, filename, location, count) values ('iPhone app',  'schaeffler-iphone.ipa',  './uploads/iphone.ipa',  0);