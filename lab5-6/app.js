const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');
const bookRoutes = require('./routes/bookRoutes');
const { graphqlHTTP } = require('express-graphql');
const { buildSchema } = require('graphql');
const Book = require('./models/Book'); // підключаємо модель книги

const app = express();
const PORT = 3000;

// Підключення до MongoDB Atlas
mongoose.connect('mongodb+srv://rabiychukdaria:P2dhnr_!iuw2R8Y@cluster0.lffllwe.mongodb.net/library?retryWrites=true&w=majority&appName=Cluster0')
  .then(() => console.log("MongoDB Atlas підключено"))
  .catch(err => console.log("Помилка MongoDB:", err));

// Налаштування Express
app.set('view engine', 'ejs');
app.use(express.static('public'));
app.use(bodyParser.urlencoded({ extended: true }));

// Роутинг для класичного сайту
app.use('/', bookRoutes);

// Оголошення GraphQL-схеми
const schema = buildSchema(`
  type Book {
    id: ID!
    title: String!
    author: String
    year: String
    author_address: String
    publisher_address: String
    price: Float
    bookstore: String
  }

  type Query {
    books: [Book]
    book(id: ID!): Book
  }

  type Mutation {
    addBook(
      title: String!
      author: String
      year: String
      author_address: String
      publisher_address: String
      price: Float
      bookstore: String
    ): Book

    updateBook(
      id: ID!
      title: String
      author: String
      year: String
      author_address: String
      publisher_address: String
      price: Float
      bookstore: String
    ): Book

    deleteBook(id: ID!): String
  }
`);

// Resolvers для операцій
const root = {
  books: async () => await Book.find(),
  
  book: async ({ id }) => await Book.findById(id),

  addBook: async (args) => {
    const book = new Book(args);
    await book.save();
    return book;
  },

  updateBook: async ({ id, ...args }) => {
    await Book.findByIdAndUpdate(id, args);
    return await Book.findById(id);
  },

  deleteBook: async ({ id }) => {
    await Book.findByIdAndDelete(id);
    return "Книга видалена";
  }
};

// Підключення GraphQL-сервера
app.use('/graphql', graphqlHTTP({
  schema,
  rootValue: root,
  graphiql: true, // Увімкнути вбудований GraphQL-браузер
}));

// Запуск сервера
app.listen(PORT, () => {
  console.log(`Сервер запущено на http://localhost:${PORT}`);
});
