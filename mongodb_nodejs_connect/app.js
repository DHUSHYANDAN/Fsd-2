const { MongoClient } = require('mongodb');
const url = 'mongodb://localhost:27017';
const client = new MongoClient(url);
const dbname = 'mydata';

async function main() {
    try {
        await client.connect();
        console.log("Server is connected to MongoDB");

        const db = client.db(dbname);

        // Adding the data to MongoDB
        const result = await db.collection("users").insertOne({ name: "velan", age: 43 });
        console.log("Document inserted successfully, ID:", result.insertedId);

        // Retrieving the data from MongoDB
        const insertedUser = await db.collection("users").findOne({ _id: result.insertedId });
        if (insertedUser) {
            console.log("User Name:", insertedUser.name, "Age:", insertedUser.age);
        } else {
            console.log("Document not found");
        }
    } catch (err) {
        console.error("Errors:", err);
    } finally {
        await client.close(); // Await client.close() to ensure the connection is closed properly
    }
}

main().catch(err => console.error("Error in main function:", err));


// cd fsd-2
// cd mongodb_nodejs_connect
// npm install mongodb
// node app.js