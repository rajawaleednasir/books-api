# Books API

A simple RESTful API built with **Laravel 12** for managing books.  
Provides CRUD operations with structured JSON responses and global API error handling.

---

## **Features**

- Create, Read, Update, Delete books
- Pagination support
- Validation using Form Requests
- Global API error handling
- JSON responses using a helper (`ApiResponse`)
- API resource routing (`apiResource`)
- Token-based authentication using **Sanctum**


---

## **Endpoints**

| Method | URL | Description | Request Body |
|--------|-----|-------------|--------------|
| GET    | `/api/books` | Get all books (paginated) | N/A |
| POST   | `/api/books` | Create a new book | `title` (string, required), `author` (string, required), `description` (string, optional), `published_at` (date, optional) |
| GET    | `/api/books/{id}` | Get a single book by ID | N/A |
| PUT/PATCH | `/api/books/{id}` | Update an existing book | Same as POST |
| DELETE | `/api/books/{id}` | Delete a book | N/A |

---

## **Request Example (POST /api/books)**

```json
{
  "title": "The Great Gatsby",
  "author": "F. Scott Fitzgerald",
  "description": "A classic novel",
  "published_at": "1925-04-10"
}
