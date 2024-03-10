# DigitalTolk Technical Exam

## Problem

Do at least ONE of the following tasks: refactor is mandatory. Write tests is optional, will be good bonus to see it.
Upload your results to a Github repo, for easier sharing and reviewing.

## Code to refactor

1) `app/Http/Controllers/BookingController.php`
2) `app/Repository/BookingRepository.php`

## Code to write tests (optional)

3) `App/Helpers/TeHelper::willExpireAt`
4) `App/Repository/UserRepository::createOrUpdate`


## Solution

In the `refactor` folder, I created a new Laravel Project and added the 4 classes based on their namespace
`DTApi\Some\Other\Directory` in the `src` folder. Please see the `composer.json` for more details.

The unit tests was placed in the `refactor/tests` folder. 
                                                                                            

I initially refactored the source code and I know this refactoring could take a lot of time.
So i decided to share my whole insights via `Code Review Analysis`



## Code Review Analysis

There are areas in the codebase that could benefit from refactoring to improve readability and maintainability.

**Controllers**
- Leverage Laravel Validation, this can be done via built-in validation rules.
Utilize form request classes.

![](.README.MD_images/5e784542.png)

- Inject the abstract implementation not the concrete classes or follow the Dependency Inversion Principle.

![](.README.MD_images/80654c8d.png)

- Use the `auth()->user()` helper method to check the authenticated user, do not pass it directly from the request.

![](.README.MD_images/c0b35acb.png)

- Wrong usage of if/else statement.
- Do not get the env values directly. Please your env variables in a config file.

![](.README.MD_images/b9f19954.png)

- Use typehints for arguments and return.

![](.README.MD_images/da37c7b6.png)

- Create slim controllers, make use of a service to inject the actual logic.

![](.README.MD_images/b23ee8dc.png)

- Don't import undefined classes.

![](.README.MD_images/4fad5062.png)

- Use proper status code for the response.

![](.README.MD_images/5b56a945.png)

**Repository**

- Adhere to Single Responsibility Principle. Don't add unrelated actions to the repository, 
like validation, email sending, notifications, etc. Separate it into a new class.

![](.README.MD_images/316f98c8.png)

![](.README.MD_images/f1b175c2.png)

- Utilize the Laravel Logger, you can create a custom logger depending on your needs.
- The constructor should have a public modifier.

![](.README.MD_images/821dd66a.png)

- Use typehints for arguments and return.

![](.README.MD_images/4c34ff67.png)

- Catch any exceptions in try/catch.

![](.README.MD_images/a53796b6.png)

- Always use mass assignment for filling the model properties. Do not access the property directly.
- Use new array syntax.
![](.README.MD_images/bc649a4f.png)

- Avoid nested if/else. 

![](.README.MD_images/7565bbb9.png)

- Utilize Laravel HTTP Class, create this client in a separate class.

![](.README.MD_images/d3fa175c.png)

**Test Class**

- Avoid nested if/else statements.

![](.README.MD_images/8820d6fb.png)

- Utilize query scopes.

![](.README.MD_images/41ab47c0.png)

Overall, the codebase should follow SOLID Principles and follow best practices in coding in able to attain scalability, reusability, traceability and readability.
Please maximize the framework features and capabilities.

`Do not reinvent the wheel.`

