<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bookhive.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create librarian user
        User::create([
            'name' => 'Librarian User',
            'email' => 'librarian@bookhive.com',
            'password' => Hash::make('password'),
            'role' => 'librarian',
        ]);

        // Create member user
        User::create([
            'name' => 'John Doe',
            'email' => 'member@bookhive.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // Create sample books
        $books = [
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'isbn' => '978-0-06-112008-4',
                'description' => 'A classic novel about racial injustice in the American South.',
                'category' => 'Fiction',
                'total_copies' => 3,
                'available_copies' => 3,
                'publication_year' => 1960,
                'publisher' => 'J. B. Lippincott & Co.',
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'isbn' => '978-0-452-28423-4',
                'description' => 'A dystopian social science fiction novel.',
                'category' => 'Science Fiction',
                'total_copies' => 2,
                'available_copies' => 2,
                'publication_year' => 1949,
                'publisher' => 'Secker & Warburg',
            ],
            [
                'title' => 'Pride and Prejudice',
                'author' => 'Jane Austen',
                'isbn' => '978-0-14-143951-8',
                'description' => 'A romantic novel of manners.',
                'category' => 'Romance',
                'total_copies' => 4,
                'available_copies' => 4,
                'publication_year' => 1813,
                'publisher' => 'T. Egerton',
            ],
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'isbn' => '978-0-7432-7356-5',
                'description' => 'A novel about the American Dream in the Jazz Age.',
                'category' => 'Fiction',
                'total_copies' => 2,
                'available_copies' => 2,
                'publication_year' => 1925,
                'publisher' => 'Charles Scribner\'s Sons',
            ],
            [
                'title' => 'The Catcher in the Rye',
                'author' => 'J.D. Salinger',
                'isbn' => '978-0-316-76948-0',
                'description' => 'A story about teenage alienation and loss of innocence.',
                'category' => 'Fiction',
                'total_copies' => 3,
                'available_copies' => 3,
                'publication_year' => 1951,
                'publisher' => 'Little, Brown and Company',
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0-13-235088-4',
                'description' => 'A handbook of agile software craftsmanship.',
                'category' => 'Technology',
                'total_copies' => 2,
                'available_copies' => 2,
                'publication_year' => 2008,
                'publisher' => 'Prentice Hall',
            ],
            [
                'title' => 'The Pragmatic Programmer',
                'author' => 'David Thomas, Andrew Hunt',
                'isbn' => '978-0-13-595705-9',
                'description' => 'Your journey to mastery in software development.',
                'category' => 'Technology',
                'total_copies' => 2,
                'available_copies' => 2,
                'publication_year' => 2019,
                'publisher' => 'Addison-Wesley',
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'isbn' => '978-0-06-231609-7',
                'description' => 'A narrative history of humanity from the Stone Age to the present.',
                'category' => 'Non-Fiction',
                'total_copies' => 3,
                'available_copies' => 3,
                'publication_year' => 2011,
                'publisher' => 'Harper',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
