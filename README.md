# Lendinvest Test

This is the technical test for lendinvest. 
For the person looking at test. Best place to start is the scenario file in /tests folder.
You will see the objects interacting in flow as described in the tech test.
You can run this project all through docker. It will automatically take care of installing phpunit and composer.

I unsure if their needed to be an api layer but I just understood this as a way of showing what I know in OOP PHP7.

# To serve this project with docker in bash type:
sudo docker-compose build
sudo docker-compose up

# To run the unit tests on the container:
sudo docker exec -it lendinvest-test_php7_1 phpunit

# To run bash on the container:
sudo docker exec -it lendinvest-test_php7_1 bash