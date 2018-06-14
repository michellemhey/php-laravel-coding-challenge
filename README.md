# Laravel Code Challenge

## Challenge

The following tasks should be performed using PHP and Laravel. The database you use should be relational, but beyond that it's your choice and it will have no bearing on the test. You are welcome to use any additional software packages you feel would help. Your results will be judged based on conformance to the spec, code quality and clarity, and user experience.

1. Create a sign-up form with two required fields—email address and full name.
2. Use https://gender-api.com/ to determine the user's gender.
3. BONUS: determine the user's country any way you can think of and pass that to the gender API to improve accuracy.
4. If the confidence of the gender API's guess is below 70%, present the user with an additional
means to specify their gender—"Male", "Female", or "Other".
5. Save the user. First name and last name should be stored in separate columns. Gender and email address should also be stored.

## What I did

I set up a users controller that does basic CRUD, as well as hit the Gender API endpoint and saves the gender and the users country based on their IP address. The code is rendered in views. If the genders guess is below 70% they are redirected to a form where they can select a gender (male, female, or other) and save it to the user. I added tests for the controller functions. You can run 

```bash
php vendor/bin/phpunit --testdox
```
to test them out.