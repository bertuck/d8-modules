## AW - Drupal modules - composer repository 


### Creation du satis dependencies

composer create-project composer/satis --stability=dev

### Mettre a jour les modules via satis.json

./satis/bin/satis build satis.json  . 

### Tester en local a la racine

php -S localhost:8001 -t .

### Liens utiles

http://blog.servergrove.com/2015/04/29/satis-building-composer-repository/
