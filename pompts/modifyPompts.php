<?php 

// function pour valider les données de modifications 
function modifyPompts(string $prompt, $pattern, string $errorMsg, string $defaultValue, bool $isEmail = false) {

    // tant que la condition n'est pas remplie, continue
    do {
        echo $prompt;

        $input = trim(fgets(STDIN));

        if($input === "") {
            return $defaultValue;
        }
        
        $isValid = $isEmail ? filter_var($input, FILTER_VALIDATE_EMAIL) : preg_match($pattern, $input);
        
        if (!$isValid) {
            echo "$errorMsg\n";
        }
    } while (!$isValid);

    return $input; 
}