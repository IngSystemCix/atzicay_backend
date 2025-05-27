<?php

return [
    1000 => [
        'message' => 'Resource not found.',
        'http_code' => 404,
    ],
    1001 => [
        'message' => 'Internal server error.',
        'http_code' => 500,
    ],
    1002 => [
        'message' => 'Connection error.',
        'http_code' => 503,
    ],
    1003 => [
        'message' => 'Invalid validation data.',
        'http_code' => 422,
    ],
    1004 => [
        'message' => 'Unauthorized.',
        'http_code' => 401,
    ],
    1005 => [
        'message' => 'Access denied.',
        'http_code' => 403,
    ],
    1006 => [
        'message' => 'Data conflict.',
        'http_code' => 409,
    ],
    1007 => [
        'message' => 'Incorrect request format.',
        'http_code' => 400,
    ],
    1008 => [
        'message' => 'Too many requests.',
        'http_code' => 429,
    ],
    1009 => [
        'message' => 'HTTP method not allowed.',
        'http_code' => 405,
    ],
    2000 => [
        'message' => 'No country records found in the database.',
        'http_code' => 404,
    ],
    2001 => [
        'message' => 'The list of countries was successfully retrieved from the database.',
        'http_code' => 200,
    ],
    2002 => [
        'message' => 'No country was found with the provided ID.',
        'http_code' => 404,
    ],
    2003 => [
        'message' => 'The country data was successfully retrieved.',
        'http_code' => 200,
    ],
    2004 => [
        'message' => 'The country was successfully created with the provided data.',
        'http_code' => 201,
    ],
    2005 => [
        'message' => 'The data provided to create the country is not valid (e.g., missing field or incorrect format).',
        'http_code' => 422,
    ],
    2100 => [
        'message' => 'No users found in the database.',
        'http_code' => 404,
    ],
    2101 => [
        'message' => 'The users were successfully retrieved from the database.',
        'http_code' => 200,
    ],
    2102 => [
        'message' => 'No user found with the provided ID.',
        'http_code' => 404,
    ],
    2103 => [
        'message' => 'The user data was successfully retrieved.',
        'http_code' => 200,
    ],
    2104 => [
        'message' => 'The data provided to create the user is not valid (e.g., duplicate email or missing required fields).',
        'http_code' => 422,
    ],
    2105 => [
        'message' => 'The user was successfully created with the provided data.',
        'http_code' => 201,
    ],
    2106 => [
        'message' => 'No user found with the provided ID to be updated.',
        'http_code' => 404,
    ],
    2107 => [
        'message' => 'The data provided to update the user is not valid (e.g., duplicate email).',
        'http_code' => 422,
    ],
    2108 => [
        'message' => 'The user was successfully updated with the new provided data.',
        'http_code' => 200,
    ],
    2109 => [
        'message' => 'No user found with the provided ID to be deleted.',
        'http_code' => 404,
    ],
    2110 => [
        'message' => 'The user was successfully deleted from the system.',
        'http_code' => 200,
    ],
    2111 => [
        'message' => 'No user found with the provided email address.',
        'http_code' => 404,
    ],
    2112 => [
        'message' => 'User successfully found with the provided email address.',
        'http_code' => 200,
    ],
    2200 => [
        'message' => 'No game instances found registered in the system.',
        'http_code' => 404,
    ],
    2201 => [
        'message' => 'Game instance list successfully retrieved.',
        'http_code' => 200,
    ],
    2202 => [
        'message' => 'No game instance found with the provided ID.',
        'http_code' => 404,
    ],
    2203 => [
        'message' => 'Game instance successfully retrieved.',
        'http_code' => 200,
    ],
    2204 => [
        'message' => 'The data provided to create the game instance is not valid.',
        'http_code' => 422,
    ],
    2205 => [
        'message' => 'Game instance successfully created.',
        'http_code' => 201,
    ],
    2206 => [
        'message' => 'The data provided to update the game instance is not valid.',
        'http_code' => 422,
    ],
    2207 => [
        'message' => 'Game instance successfully updated.',
        'http_code' => 200,
    ],
    2208 => [
        'message' => 'The game instance being updated was not found.',
        'http_code' => 404,
    ],
    2209 => [
        'message' => 'Game instance successfully deleted.',
        'http_code' => 200,
    ],
    2300 => [
        'message' => 'No game schedules found for the registered games.',
        'http_code' => 404,
    ],
    2301 => [
        'message' => 'Scheduled games list successfully retrieved.',
        'http_code' => 200,
    ],
    2302 => [
        'message' => 'No game schedule found with the provided ID.',
        'http_code' => 404,
    ],
    2303 => [
        'message' => 'Game schedule successfully retrieved.',
        'http_code' => 200,
    ],
    2304 => [
        'message' => 'The data provided to create a game schedule is not valid (missing field or incorrect format).',
        'http_code' => 422,
    ],
    2305 => [
        'message' => 'Game schedule successfully created.',
        'http_code' => 201,
    ],
    2306 => [
        'message' => 'The game schedule with the provided ID was not found.',
        'http_code' => 404,
    ],
    2307 => [
        'message' => 'The data provided for the game schedule is not valid (missing field or incorrect format).',
        'http_code' => 422,
    ],
    2308 => [
        'message' => 'Game schedule successfully updated.',
        'http_code' => 200,
    ],
    2309 => [
        'message' => 'The game schedule with the provided ID was not found.',
        'http_code' => 404,
    ],
    2310 => [
        'message' => 'Game schedule successfully deleted.',
        'http_code' => 200,
    ],
    2400 => [
        'message' => 'No game evaluations found.',
        'http_code' => 404,
    ],
    2401 => [
        'message' => 'Game evaluations successfully retrieved.',
        'http_code' => 200,
    ],
    2402 => [
        'message' => 'La evaluación solicitada no fue encontrada.',
        'http_code' => 404,
    ],
    2403 => [
        'message' => 'Evaluation successfully retrieved.',
        'http_code' => 200,
    ],
    2404 => [
        'message' => 'Game evaluation successfully created.',
        'http_code' => 201,
    ],
    2405 => [
        'message' => 'The data provided for the game evaluation is invalid.',
        'http_code' => 422,
    ],
    2406 => [
        'message' => 'The data provided for the game evaluation is invalid.',
        'http_code' => 200,
    ],
    2407 => [
        'message' => 'The requested game evaluation was not found.',
        'http_code' => 404,
    ],
    2408 => [
        'message' => 'The data provided for the game evaluation is invalid.',
        'http_code' => 422,
    ],
    2409 => [
        'message' => 'Game evaluation successfully deleted.',
        'http_code' => 200,
    ],
    2410 => [
        'message' => 'The requested game evaluation was not found.',
        'http_code' => 404,
    ],
    2411 => [
        'message' => 'Internal error while trying to delete the game evaluation.',
        'http_code' => 500,
    ],
    2500 => [
        'message' => 'Game configuration found.',
        'http_code' => 200,
    ],
    2501 => [
        'message' => 'The requested game configuration was not found.',
        'http_code' => 404,
    ],
    2502 => [
        'message' => 'Internal error while trying to retrieve the game configuration.',
        'http_code' => 500,
    ],
    2503 => [
        'message' => 'Game configuration successfully created.',
        'http_code' => 201,
    ],
    2504 => [
        'message' => 'The data provided for the game configuration is not valid.',
        'http_code' => 422,
    ],
    2505 => [
        'message' => 'Internal error while creating the game configuration.',
        'http_code' => 500,
    ],
    2506 => [
        'message' => 'Game configuration successfully updated.',
        'http_code' => 200,
    ],
    2507 => [
        'message' => 'The data provided to update the game configuration is not valid.',
        'http_code' => 422,
    ],
    2508 => [
        'message' => 'The game configuration with the provided ID was not found.',
        'http_code' => 404,
    ],
    2509 => [
        'message' => 'Internal error while updating the game configuration.',
        'http_code' => 500,
    ],
    2600 => [
        'message' => 'Hangman game successfully retrieved.',
        'http_code' => 200,
    ],
    2601 => [
        'message' => 'No hangman games found.',
        'http_code' => 404,
    ],
    2602 => [
        'message' => 'Internal error while retrieving hangman games.',
        'http_code' => 500,
    ],
    2603 => [
        'message' => 'Hangman game successfully retrieved.',
        'http_code' => 200,
    ],
    2604 => [
        'message' => 'The hangman game with the provided ID was not found.',
        'http_code' => 404,
    ],
    2605 => [
        'message' => 'Internal error while searching for the hangman game.',
        'http_code' => 500,
    ],
    2606 => [
        'message' => 'Hangman game successfully created.',
        'http_code' => 201,
    ],
    2607 => [
        'message' => 'Invalid data provided for the hangman game. Please check the provided information.',
        'http_code' => 422,
    ],
    2608 => [
        'message' => 'Internal error while creating the hangman game.',
        'http_code' => 500,
    ],
    2609 => [
        'message' => 'Hangman game successfully updated.',
        'http_code' => 200,
    ],
    2610 => [
        'message' => 'Invalid data provided to update the hangman game. Please review the submitted fields.',
        'http_code' => 422,
    ],
    2611 => [
        'message' => 'Hangman game not found.',
        'http_code' => 404,
    ],
    2612 => [
        'message' => 'Internal error while updating the hangman game.',
        'http_code' => 500,
    ],
    2700 => [
        'message' => 'Word search game successfully retrieved.',
        'http_code' => 200,
    ],
    2701 => [
        'message' => 'Word search game not found with the provided ID.',
        'http_code' => 404,
    ],
    2702 => [
        'message' => 'Internal error while searching for the \'Word Search\' game.',
        'http_code' => 500,
    ],
    2703 => [
        'message' => 'Word search game successfully created.',
        'http_code' => 201,
    ],
    2704 => [
        'message' => 'Invalid data to create the \'Word Search\' game.',
        'http_code' => 422,
    ],
    2705 => [
        'message' => 'Internal error while creating the \'Word Search\' game.',
        'http_code' => 500,
    ],
    2706 => [
        'message' => 'Word search game successfully updated.',
        'http_code' => 200,
    ],
    2707 => [
        'message' => 'Word search game not found for update.',
        'http_code' => 404,
    ],
    2708 => [
        'message' => 'Invalid data to update the \'Word Search\' game.',
        'http_code' => 422,
    ],
    2709 => [
        'message' => 'Internal error while updating the \'Word Search\' game.',
        'http_code' => 500,
    ],
    2800 => [
        'message' => 'Memory game successfully retrieved.',
        'http_code' => 200,
    ],
    2801 => [
        'message' => 'Memory game not found with the specified ID.',
        'http_code' => 404,
    ],
    2802 => [
        'message' => 'Internal error while searching for the memory game.',
        'http_code' => 500,
    ],
    2803 => [
        'message' => 'Memory game successfully created.',
        'http_code' => 201,
    ],
    2804 => [
        'message' => 'The data provided to create the memory game is invalid.',
        'http_code' => 422,
    ],
    2805 => [
        'message' => 'Internal error while attempting to create the memory game.',
        'http_code' => 500,
    ],
    2806 => [
        'message' => 'Memory game successfully updated.',
        'http_code' => 200,
    ],
    2807 => [
        'message' => 'The data provided to update the memory game is invalid.',
        'http_code' => 422,
    ],
    2808 => [
        'message' => 'Memory game not found with the specified ID.',
        'http_code' => 404,
    ],
    2809 => [
        'message' => 'Internal error while attempting to update the memory game.',
        'http_code' => 500,
    ],
    2900 => [
        'message' => 'Puzzle found successfully.',
        'http_code' => 200,
    ],
    2901 => [
        'message' => 'Puzzle not found with the specified ID.',
        'http_code' => 404,
    ],
    2902 => [
        'message' => 'Internal error while attempting to retrieve the puzzle.',
        'http_code' => 500,
    ],
    2903 => [
        'message' => 'Puzzle successfully created.',
        'http_code' => 201,
    ],
    2904 => [
        'message' => 'Puzzle successfully created.',
        'http_code' => 422,
    ],
    2905 => [
        'message' => 'Internal error while attempting to create the puzzle.',
        'http_code' => 500,
    ],
    2906 => [
        'message' => 'Puzzle successfully updated.',
        'http_code' => 200,
    ],
    2907 => [
        'message' => 'The puzzle data is invalid.',
        'http_code' => 422,
    ],
    2908 => [
        'message' => 'Puzzle not found for update.',
        'http_code' => 404,
    ],
    2909 => [
        'message' => 'Internal error while attempting to update the puzzle.',
        'http_code' => 500,
    ],
    3000 => [
        'message' => 'Game session found.',
        'http_code' => 200,
    ],
    3001 => [
        'message' => 'Game session not found.',
        'http_code' => 404,
    ],
    3002 => [
        'message' => 'Internal error while retrieving the game session.',
        'http_code' => 500,
    ],
    3003 => [
        'message' => 'Game session created successfully.',
        'http_code' => 201,
    ],
    3004 => [
        'message' => 'Invalid request, the provided game session data for creation is invalid.',
        'http_code' => 422,
    ],
    3005 => [
        'message' => 'Internal error while creating the game session.',
        'http_code' => 500,
    ],
    3006 => [
        'message' => 'Game session updated successfully.',
        'http_code' => 200,
    ],
    3007 => [
        'message' => 'Invalid request, the provided game session data for update is invalid.',
        'http_code' => 422,
    ],
    3008 => [
        'message' => 'Game session not found.',
        'http_code' => 404,
    ],
    3009 => [
        'message' => 'Internal error while updating the game session.',
        'http_code' => 500,
    ],
    3100 => [
        'message' => 'Word found successfully.',
        'http_code' => 200,
    ],
    3101 => [
        'message' => 'Word not found.',
        'http_code' => 404,
    ],
    3102 => [
        'message' => 'Internal error while retrieving the word.',
        'http_code' => 500,
    ],
    3103 => [
        'message' => 'Word created successfully.',
        'http_code' => 201,
    ],
    3104 => [
        'message' => 'Error creating the word: invalid data.',
        'http_code' => 422,
    ],
    3105 => [
        'message' => 'Internal error while creating the word.',
        'http_code' => 500,
    ],
    3106 => [
        'message' => 'Word updated successfully.',
        'http_code' => 200,
    ],
    3107 => [
        'message' => 'Error updating the word: invalid data.',
        'http_code' => 422,
    ],
    3108 => [
        'message' => 'Word not found for update.',
        'http_code' => 404,
    ],
    3109 => [
        'message' => 'Internal error while updating the word.',
        'http_code' => 500,
    ],
    3200 => [
        'message' => 'Game type found successfully.',
        'http_code' => 200,
    ],
    3201 => [
        'message' => 'Game progress not found.',
        'http_code' => 404,
    ],
    3202 => [
        'message' => 'Internal error while retrieving the game progress.',
        'http_code' => 500,
    ],
    3203 => [
        'message' => 'Game progress created successfully.',
        'http_code' => 201,
    ],
    3204 => [
        'message' => 'Invalid data to create the game progress.',
        'http_code' => 422,
    ],
    3205 => [
        'message' => 'Internal error while creating the game progress.',
        'http_code' => 500,
    ],
    3206 => [
        'message' => 'Game progress updated successfully.',
        'http_code' => 200,
    ],
    3207 => [
        'message' => 'Invalid data to update the game progress.',
        'http_code' => 422,
    ],
    3208 => [
        'message' => 'Game progress not found for update.',
        'http_code' => 404,
    ],
    3209 => [
        'message' => 'Internal error while updating the game progress.',
        'http_code' => 500,
    ],
    2210 => [
        'message' => 'The games you are trying to retrieve were not found.',
        'http_code' => 404,
    ],
    2211 => [
        'message' => 'The games were successfully retrieved.',
        'http_code' => 200,
    ],
    2710 => [
        'message' => 'word search games retrieved successfully',
        'http_code' => 200,
    ],
    2711 => [
        'message' => 'word search games not found',
        'http_code' => 404,
    ],
    2810 => [
        'message' => 'memory games retrieved successfully',
        'http_code' => 200,
    ],
    2811 => [
        'message' => 'memory games not found',
        'http_code' => 404,
    ],
    2910 => [
        'message' => 'puzzle games retrieved successfully',
        'http_code' => 200,
    ],
    2911 => [
        'message' => 'puzzle games not found',
        'http_code' => 404,
    ],
    2212 => [
        'message' => 'The search by filter was found.',
        'http_code' => 200,
    ],
    2213 => [
        'message' => 'There are no results to display for the search.',
        'http_code' => 404,
    ],
    2214 => [
        'message' => 'Game instance created successfully',
        'http_code' => 201,
    ],
    2215 => [
        'message' => 'Failed to create game instance.',
        'http_code' => 500,
    ],
    2216 => [
        'message' => 'Game get configuration successfully',
        'http_code' => 200,
    ],
    2217 => [
        'message' => 'Failed get configuration game',
        'http_code' => 404,
    ],
];