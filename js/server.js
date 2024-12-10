const express = require("express");
const bodyParser = require("body-parser");
const mysql = require("mysql");

const app = express();
app.use(bodyParser.json());

// MySQL database connection
const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "RoyalStreet",
    database: "Shahae",
});

db.connect(err => {
    if (err) throw err;
    console.log("Connected to database");
});

// Handle form submission
app.post("/submit-form", (req, res) => {
    const { name, mobile, email } = req.body;
    const query = "INSERT INTO form_submissions (name, mobile_number, email_id) VALUES (?, ?, ?)";
    db.query(query, [name, mobile, email], (err) => {
        if (err) {
            console.error(err);
            return res.status(500).json({ message: "Failed to submit form" });
        }
        res.status(200).json({ message: "Form submitted successfully!" });
        emailjs.init("QJweFZIOi0I1mwEr1");
        emailjs.sendForm('contact_service', 'template_contact', '#contact-form');


    });
});

// Start the server
app.listen(5000, () => {
    console.log("Server running on http://localhost:5000");
});
