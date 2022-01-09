
# Catch Coding Challenge 1

This project using Symfony 5.3.* and PHP >=7.2.5

## Authors

- [Linda Sebastian](https://github.com/rocklinda)
- [Linkedin](https://www.linkedin.com/in/linda-sebastian-97903461/)

## Task

Read a data file, process each record, and produce an output file.

The input file is in jsonlines format (http://jsonlines.org), with each record representing an ecommerce order. Each order contains data about the customer, shipping details, payment data, items purchased, and any applied discounts. The file is available in AWS S3 at https://s3-ap-southeast-2.amazonaws.com/catch-code-challenge/challenge-1-in.jsonl

You need to write a program that produces a new output csv file `out.csv` with the data defined in the table below, with a single record per order. The output file should be a well-formed CSV (according to https://csvlint.io) file with the following fields, which represents a summary of the data from the input file.

| order_id            | The numeric order id
| order_datetime      | The datetime the order was placed in ISO 8601 format in the UTC timezone.
| total_order_value   | The dollar sum of all line items in the order, *excluding* shipping, with all discounts applied. Note, discounts do not apply to shipping.
| average_unit_price  | The average price of each unit in the order, in dollars.
| distinct_unit_count | The count of unique units contained in the order.
| total_units_count   | The total number of units in the order
| customer_state      | The state code from the customer’s shipping address, e.g. "Victoria"

## Requirements 7/7

- [x] The input file should be automatically downloaded from the internet each time the program is run.
- [x] Order records with 0 total order value should be excluded from the summary output.
- [x] The program should be run via a single command line invocation i.e., a traditional CLI application.
- [x] Include a README file with your name and contact details which explains any coding or architecture decisions you made, along with instructions to bootstrap and run your program.
- [x] Manage your project in a GIT repository, committing parts as you build out your program.
- [x] Use a package manager to manage dependencies and autoloading.
- [x] Write unit tests for your program

## Recommendations 1/2

- [x] Use third party libraries and packages where appropriate. If you specifically want to write a component you know is available off the shelf, write your reasons for doing so in the readme.
- [] Use a code formatter to ensure code-style consistency, a code linter or static analysis tool.

## Bonus points 2/4

The below are suggestions for ways to show-off some additional skills. There is no requirement to do any of the bonus points. Also feel free to use your imagination and surprise us!

- [x] Specify as an argument to the program an email to which the output should be sent.
- Use a third-party API to enrich the output data, e.g. geocode the customers address into latitude and longitude. Be creative!
- Validate your CSV output file programmatically via a third-party API either as part of the standard generation, or as a separate console command or script.
- [x] Allow formatting of the output file to be in one or more other formats, e.g. jsonl, XML, Yaml, etc.

## Judging notes

- Ensure that your program is well structured, not all in one file.
- Think about separating concerns within the program in line with best practice.
- Would your code work with a 1TB input file?
- Do you have well-written unit and functional tests?


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file

`MAILER_DSN=mail@example.com`

`EMAIL_SENDER=gmail://USERNAME:PASSWORD@default`


## Features

- Default command will generate file in csv
- Command to generate file in csv, jsonl, or xml
- Command option to send file to an email as attachement

## Run Locally

Clone the project

```bash
  git clone git@github.com:rocklinda/CatchGenerateFileChallenge.git
```

Go to the project directory

```bash
  cd CatchGenerateFileChallenge
```

Install dependencies

```bash
  composer install
```

## Usage/Examples

Run command without argument

```bash
  symfony php bin/console app:GenerateOrderSummary
```

Run command with format file argument

```bash
  symfony php bin/console app:GenerateOrderSummary --formatFile xml
```

Run command with format file argument and send to an email

```bash
  symfony php bin/console app:GenerateOrderSummary --formatFile jsonl --email example@mail.com
```


## Running Tests

To run tests, run the following command

```bash
  symfony php bin/phpunit tests/
```


## Coding Explanation

- The command will automatically read file from s3 then my code will read line by line and convert to OrderSummary objcet. After this will create csv/jsonl/xml file. And will send to an email
- For sending an email I use symfony/google-mailer
- Before sending an email you need to checklist your gmail account with less secure app [https://support.google.com/accounts/answer/6010255?hl=en]




## Lessons Learned

It's been a while since I write code in Symfony so I need extra time to come across read the documentation and some youtube tutorials.
The biggest challenge was to write unit testing, I still need to improve my code especially to mock results. In this code, I passed the result directly to the real one instead use the mock result.
## What Need to be Improved

There some area that need to improve in this project

- Create Event Listeners to send an email asynchronously 
- Using mock result in unit test
- Covering all test cases including service and utility
