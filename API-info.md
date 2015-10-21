# Adding a new poll #
Input (POST):

        name (string, length: 5 - 100 characters)
        options (array of strings - names, max 10 options)
        private (boolean)
        expDate (UNIX timestamp)

Output (JSON):

        id (number, when successful)
        error (JSON object, when unsuccessful):
            code (number, list of error codes is at the bottom of this document)
            message (string, in English what's wrong)






# Voting #
Input (POST):

        id (number, poll's ID)
        optionID (number, option's ID)

Output (JSON):

        successful (boolean)
        error (JSON object, when unsuccessful):
            code (number, list of error codes is at the bottom of this document)
            message (string, in English what's wrong)






# Showing polls #
Input (GET):

        startFrom (number, start listing from the nth most popular poll, indexed from 0)
        limitTo (number, limit to n most popular polls)

Output (JSON):

        array of Poll objects:
            id (number)
            name (string)
            options (array):
                id (number)
                name (number)
                amount (number, only when the user has already voted on that poll, otherwise 0)
            expDate (UNIX timestamp)
            hasVoted (boolean)

For the first 3 most popular ones (in the whole database) include amounts regardless of whether the user has already voted or not (this is done in order to display them on the main page in a chart).





# Show a single poll #
Input (GET):

        id (number)

Output (JSON):

        id (number)
        name (string)
        options (array):
            id (number)
            name (number)
            amount (number, only when the user has already voted on that poll, otherwise 0)
        expDate (UNIX timestamp)
        private (boolean)
        hasVoted (boolean)






# Reporting errors #
If any error occurs script should return with a specific JSON object instead of just echoing the result.


## Error codes ##
Following error codes should be used:

        0 - no error (existance - unknown)
        1 - connection to the database unavailable
        2 - database does not exist
        3 - SQL error (include it in the message of the JSON error)

There are specific error codes for specific API tasks:


### Adding a new poll ###

        4 - name too short/too long/has unallowed characters
        5 - options are in wrong format
        6 - date in wrong format
        7 - date relates to the past

### Voting ###

        8 - wrong poll's ID
        9 - wrong option's ID

### Showing polls ###

        10 - GET parameters not given (either of them)

### Show a single poll ###

        11 - wrong poll's ID
    