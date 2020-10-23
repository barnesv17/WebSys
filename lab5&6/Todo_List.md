# Lab 5&6 jQuery

###### Link to lab doc: https://docs.google.com/document/d/1_V2MLMA4_UTSBUSlduGj9Hh9q-wonEmQjTyPVqG_dps/edit

1. README

   - Development Log
   - Members, members' tasks  and contribution

2. HTML

   - `<noscript>` tag to to deliver user-friendly message when JS is disabled?

   - Instruction/Home Page
   - Game Page
     - Start
     - Settings
     - Allow users to pause?
   - About
     - Repo address
     - Feedback

3. CSS

   - Color
   - Font
   - Layout/Positioning

4. JS

   - To be included as jQuery plug-in (https://learn.jquery.com/plugins/basic-plugin-creation/)

   - `New Game` button to start and load the window

   - `Settings` button or icon should be hidden while in-game

   - Randomly generated color swatch by RGB value (Math Object)

   - Three `jQuery UI sliders` for R, G, and B (displayed below color swatch presented to users)
     - Display `hex values` (00-FF), and have indication of  current hex values
       - Update text area value when users move the corresponding slider
     - Adjacent text areas for input hex values by users
       - Update the corresponding slider when users type in hex values
         - Be able to identify input hex validity (regex `/^([0-9A-Fa-f]{2})$/`  )

   - `Guess` button to submit users' guesses. 

     - Calculate each base color's percentage off
       - `percentoff = (abs(correct value - guess value) / 255) * 100`
       - Need a `hex -> int` translation
         - or JS function `parseInt(): parseInt("0xFF") = 255`
     - Return `feedbacks` as percentages, e.g.
       - 0% "Perfect!"
       - (0, 10] % "Close!"
       - (10, 30] % "Keep trying!"
       - (30, 60] % "That's all you got??"
       - (60, 90] % "Not even close"
       
        - (90, 100] % "You suck"  (potentially)

     - Update feedback each time user guesses

   - Indication of number of guesses available/left  |  User's timer (from 0:00)

     - If either of above runs out, `New Game` should replace `Guess`
       - New color swatch generates, everything resets to default
     
   - After each guess, score should be displayed (Initially 0 or a user-friendly indication)
     
     - `(300 - (percentoff_red + percentoff_green + percentoff_blue)) * ((20000 - milliseconds_taken) < 0 ? 0 : (20000 - milliseconds_taken))`
       
     - Keep the best score persistent on the page, replace it with current score if it is higher
       - If `current score` is equal to or less than `high score` 
         - Indicate below the high score with a different color, until next guess
           - If next guess is higher than the last/below-high-score, replace it with this score (if I'm understanding correctly)
       - Otherwise, replace the high score with `current score`, and indicate the last high score (2nd highest) below (if I'm understanding correctly)
   
5. JSON

   - Taken in by `Settings` parameter to allow for game-play defining.
     - Player name
     - Number of turns (1-5, default to 3)
       - Check validity



   

   

