# Adding a new poll #
Input (POST):

        name (string, length: 10 - 100 characters)
        options ()
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

        startFrom (number, start listing from the nth most popular poll)
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
