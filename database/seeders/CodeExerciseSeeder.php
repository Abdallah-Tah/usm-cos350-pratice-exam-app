<?php

namespace Database\Seeders;

use App\Models\CodeExercise;
use Illuminate\Database\Seeder;

class CodeExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $exercises = [
            [
                'exercise_number' => 1,
                'title' => 'Implement strlen',
                'category' => 'strings',
                'difficulty' => 'easy',
                'description' => 'Write a function that calculates the length of a string without using the built-in strlen function.',
                'instructions' => 'Complete the my_strlen function that takes a string and returns its length. Do not use the built-in strlen() function.',
                'starter_code' => '#include <stdio.h>

int my_strlen(const char *str) {
    // TODO: Implement this function
    // Count characters until you reach \'\\0\'

}

int main() {
    printf("%d\\n", my_strlen("Hello"));      // Should print 5
    printf("%d\\n", my_strlen(""));           // Should print 0
    printf("%d\\n", my_strlen("COS 350"));    // Should print 7
    return 0;
}',
                'solution_code' => '#include <stdio.h>

int my_strlen(const char *str) {
    int len = 0;
    while (str[len] != \'\\0\') {
        len++;
    }
    return len;
}

int main() {
    printf("%d\\n", my_strlen("Hello"));      // Should print 5
    printf("%d\\n", my_strlen(""));           // Should print 0
    printf("%d\\n", my_strlen("COS 350"));    // Should print 7
    return 0;
}',
                'test_cases' => [
                    ['input' => 'Hello', 'expected' => '5'],
                    ['input' => '', 'expected' => '0'],
                    ['input' => 'COS 350', 'expected' => '7'],
                ],
                'hints' => 'Remember that strings in C are null-terminated. Loop through the string until you encounter the null character (\\0).',
            ],
            [
                'exercise_number' => 2,
                'title' => 'Implement strcpy',
                'category' => 'strings',
                'difficulty' => 'easy',
                'description' => 'Write a function that copies one string to another without using strcpy.',
                'instructions' => 'Complete the my_strcpy function. Copy the source string to the destination, including the null terminator.',
                'starter_code' => '#include <stdio.h>

void my_strcpy(char *dest, const char *src) {
    // TODO: Copy src to dest character by character
    // Don\'t forget the null terminator!

}

int main() {
    char dest[50];
    my_strcpy(dest, "Hello World");
    printf("%s\\n", dest);  // Should print "Hello World"
    return 0;
}',
                'solution_code' => '#include <stdio.h>

void my_strcpy(char *dest, const char *src) {
    int i = 0;
    while (src[i] != \'\\0\') {
        dest[i] = src[i];
        i++;
    }
    dest[i] = \'\\0\';  // Don\'t forget the null terminator
}

int main() {
    char dest[50];
    my_strcpy(dest, "Hello World");
    printf("%s\\n", dest);  // Should print "Hello World"
    return 0;
}',
                'test_cases' => [
                    ['input' => 'Hello World', 'expected' => 'Hello World'],
                    ['input' => 'COS350', 'expected' => 'COS350'],
                ],
                'hints' => 'Use a loop to copy each character. Don\'t forget to copy the null terminator (\\0) at the end!',
            ],
            [
                'exercise_number' => 3,
                'title' => 'Reverse a String',
                'category' => 'strings',
                'difficulty' => 'medium',
                'description' => 'Write a function that reverses a string in place.',
                'instructions' => 'Complete the reverse_string function. Reverse the string in place without using any extra arrays.',
                'starter_code' => '#include <stdio.h>
#include <string.h>

void reverse_string(char *str) {
    // TODO: Reverse the string in place
    // Hint: Use two pointers, one at start and one at end

}

int main() {
    char str1[] = "hello";
    reverse_string(str1);
    printf("%s\\n", str1);  // Should print "olleh"

    char str2[] = "COS350";
    reverse_string(str2);
    printf("%s\\n", str2);  // Should print "053SOC"

    return 0;
}',
                'solution_code' => '#include <stdio.h>
#include <string.h>

void reverse_string(char *str) {
    int len = strlen(str);
    int i = 0;
    int j = len - 1;

    while (i < j) {
        char temp = str[i];
        str[i] = str[j];
        str[j] = temp;
        i++;
        j--;
    }
}

int main() {
    char str1[] = "hello";
    reverse_string(str1);
    printf("%s\\n", str1);  // Should print "olleh"

    char str2[] = "COS350";
    reverse_string(str2);
    printf("%s\\n", str2);  // Should print "053SOC"

    return 0;
}',
                'test_cases' => [
                    ['input' => 'hello', 'expected' => 'olleh'],
                    ['input' => 'COS350', 'expected' => '053SOC'],
                ],
                'hints' => 'Use two pointers: one at the beginning and one at the end. Swap characters and move the pointers toward each other.',
            ],
            [
                'exercise_number' => 4,
                'title' => 'Count Vowels',
                'category' => 'strings',
                'difficulty' => 'easy',
                'description' => 'Write a function that counts the number of vowels in a string.',
                'instructions' => 'Complete the count_vowels function. Count both uppercase and lowercase vowels (a, e, i, o, u).',
                'starter_code' => '#include <stdio.h>
#include <ctype.h>

int count_vowels(const char *str) {
    // TODO: Count vowels (a, e, i, o, u) - both upper and lowercase

}

int main() {
    printf("%d\\n", count_vowels("hello"));        // Should print 2
    printf("%d\\n", count_vowels("AEIOU"));        // Should print 5
    printf("%d\\n", count_vowels("rhythm"));       // Should print 0
    printf("%d\\n", count_vowels("COS 350 Exam")); // Should print 3
    return 0;
}',
                'solution_code' => '#include <stdio.h>
#include <ctype.h>

int count_vowels(const char *str) {
    int count = 0;
    for (int i = 0; str[i] != \'\\0\'; i++) {
        char c = tolower(str[i]);
        if (c == \'a\' || c == \'e\' || c == \'i\' || c == \'o\' || c == \'u\') {
            count++;
        }
    }
    return count;
}

int main() {
    printf("%d\\n", count_vowels("hello"));        // Should print 2
    printf("%d\\n", count_vowels("AEIOU"));        // Should print 5
    printf("%d\\n", count_vowels("rhythm"));       // Should print 0
    printf("%d\\n", count_vowels("COS 350 Exam")); // Should print 3
    return 0;
}',
                'test_cases' => [
                    ['input' => 'hello', 'expected' => '2'],
                    ['input' => 'AEIOU', 'expected' => '5'],
                    ['input' => 'rhythm', 'expected' => '0'],
                ],
                'hints' => 'Convert each character to lowercase using tolower() to handle both cases. Check if it matches any vowel.',
            ],
            [
                'exercise_number' => 5,
                'title' => 'Array Sum',
                'category' => 'arrays',
                'difficulty' => 'easy',
                'description' => 'Write a function that calculates the sum of all elements in an integer array.',
                'instructions' => 'Complete the array_sum function. Add up all the numbers in the array and return the total.',
                'starter_code' => '#include <stdio.h>

int array_sum(int arr[], int size) {
    // TODO: Calculate and return the sum of all array elements

}

int main() {
    int arr1[] = {1, 2, 3, 4, 5};
    printf("%d\\n", array_sum(arr1, 5));  // Should print 15

    int arr2[] = {10, 20, 30};
    printf("%d\\n", array_sum(arr2, 3));  // Should print 60

    return 0;
}',
                'solution_code' => '#include <stdio.h>

int array_sum(int arr[], int size) {
    int sum = 0;
    for (int i = 0; i < size; i++) {
        sum += arr[i];
    }
    return sum;
}

int main() {
    int arr1[] = {1, 2, 3, 4, 5};
    printf("%d\\n", array_sum(arr1, 5));  // Should print 15

    int arr2[] = {10, 20, 30};
    printf("%d\\n", array_sum(arr2, 3));  // Should print 60

    return 0;
}',
                'test_cases' => [
                    ['input' => '[1,2,3,4,5]', 'expected' => '15'],
                    ['input' => '[10,20,30]', 'expected' => '60'],
                ],
                'hints' => 'Use a loop to iterate through the array and add each element to a running sum.',
            ],
            [
                'exercise_number' => 6,
                'title' => 'Find Maximum in Array',
                'category' => 'arrays',
                'difficulty' => 'easy',
                'description' => 'Write a function that finds the maximum value in an array.',
                'instructions' => 'Complete the find_max function. Return the largest value in the array.',
                'starter_code' => '#include <stdio.h>

int find_max(int arr[], int size) {
    // TODO: Find and return the maximum value
    // Assume size is at least 1

}

int main() {
    int arr1[] = {3, 7, 2, 9, 1};
    printf("%d\\n", find_max(arr1, 5));  // Should print 9

    int arr2[] = {-5, -1, -10, -3};
    printf("%d\\n", find_max(arr2, 4));  // Should print -1

    return 0;
}',
                'solution_code' => '#include <stdio.h>

int find_max(int arr[], int size) {
    int max = arr[0];
    for (int i = 1; i < size; i++) {
        if (arr[i] > max) {
            max = arr[i];
        }
    }
    return max;
}

int main() {
    int arr1[] = {3, 7, 2, 9, 1};
    printf("%d\\n", find_max(arr1, 5));  // Should print 9

    int arr2[] = {-5, -1, -10, -3};
    printf("%d\\n", find_max(arr2, 4));  // Should print -1

    return 0;
}',
                'test_cases' => [
                    ['input' => '[3,7,2,9,1]', 'expected' => '9'],
                    ['input' => '[-5,-1,-10,-3]', 'expected' => '-1'],
                ],
                'hints' => 'Initialize max with the first element, then loop through the rest comparing each element to the current max.',
            ],
            [
                'exercise_number' => 7,
                'title' => 'Swap Two Integers',
                'category' => 'pointers',
                'difficulty' => 'easy',
                'description' => 'Write a function that swaps two integers using pointers.',
                'instructions' => 'Complete the swap function using pointers to exchange the values of two variables.',
                'starter_code' => '#include <stdio.h>

void swap(int *a, int *b) {
    // TODO: Swap the values pointed to by a and b
    // Use a temporary variable

}

int main() {
    int x = 5, y = 10;
    printf("Before: x=%d, y=%d\\n", x, y);
    swap(&x, &y);
    printf("After: x=%d, y=%d\\n", x, y);  // Should print x=10, y=5
    return 0;
}',
                'solution_code' => '#include <stdio.h>

void swap(int *a, int *b) {
    int temp = *a;
    *a = *b;
    *b = temp;
}

int main() {
    int x = 5, y = 10;
    printf("Before: x=%d, y=%d\\n", x, y);
    swap(&x, &y);
    printf("After: x=%d, y=%d\\n", x, y);  // Should print x=10, y=5
    return 0;
}',
                'test_cases' => [
                    ['input' => '5,10', 'expected' => '10,5'],
                ],
                'hints' => 'Dereference the pointers (*a, *b) to access and modify the actual values. Use a temporary variable to hold one value during the swap.',
            ],
            [
                'exercise_number' => 8,
                'title' => 'Palindrome Check',
                'category' => 'strings',
                'difficulty' => 'medium',
                'description' => 'Write a function that checks if a string is a palindrome.',
                'instructions' => 'Complete the is_palindrome function. Return 1 if the string reads the same forwards and backwards, 0 otherwise. Ignore case.',
                'starter_code' => '#include <stdio.h>
#include <string.h>
#include <ctype.h>

int is_palindrome(const char *str) {
    // TODO: Check if str is a palindrome
    // Use two pointers: one from start, one from end

}

int main() {
    printf("%d\\n", is_palindrome("racecar"));  // Should print 1
    printf("%d\\n", is_palindrome("hello"));    // Should print 0
    printf("%d\\n", is_palindrome("A"));        // Should print 1
    printf("%d\\n", is_palindrome("Madam"));    // Should print 1
    return 0;
}',
                'solution_code' => '#include <stdio.h>
#include <string.h>
#include <ctype.h>

int is_palindrome(const char *str) {
    int len = strlen(str);
    int i = 0;
    int j = len - 1;

    while (i < j) {
        if (tolower(str[i]) != tolower(str[j])) {
            return 0;  // Not a palindrome
        }
        i++;
        j--;
    }
    return 1;  // Is a palindrome
}

int main() {
    printf("%d\\n", is_palindrome("racecar"));  // Should print 1
    printf("%d\\n", is_palindrome("hello"));    // Should print 0
    printf("%d\\n", is_palindrome("A"));        // Should print 1
    printf("%d\\n", is_palindrome("Madam"));    // Should print 1
    return 0;
}',
                'test_cases' => [
                    ['input' => 'racecar', 'expected' => '1'],
                    ['input' => 'hello', 'expected' => '0'],
                    ['input' => 'Madam', 'expected' => '1'],
                ],
                'hints' => 'Use two pointers, one from each end. Compare characters (case-insensitive) and move inward. If any mismatch, it\'s not a palindrome.',
            ],
        ];

        CodeExercise::truncate();

        foreach ($exercises as $exercise) {
            CodeExercise::create($exercise);
        }
    }
}
