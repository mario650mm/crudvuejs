#!/bin/bash
mysql -uhomestead -psecret crudvue < database/scripts/1_countries.sql
mysql -uhomestead -psecret crudvue < database/scripts/2_states.sql
mysql -uhomestead -psecret crudvue < database/scripts/3_cities.sql
