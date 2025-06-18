const express = require("express");
const hbs = require("hbs");
const path = require("path");
const axios = require("axios");
const fetch = require('node-fetch');

const app = express();  
const port = 3000;

app.set("view engine", "hbs");
app.set("views", path.join(__dirname, "views"));
hbs.registerPartials(path.join(__dirname, "/views/partials"));

const cityMap = {
    Lviv: "Lviv",
    Ternopil: "Ternopil",
    Odesa: "Odesa",
    Kyiv: "Kyiv",
    Cherkasy: "Cherkasy",
    Obukhiv: "Obukhiv"
};

app.get("/", (req, res) => {
    res.render("weather", { cities: Object.keys(cityMap) });
});

app.get("/weather/:city", async (req, res) => {
    const urlCity = req.params.city;
    const city = cityMap[urlCity]; 

    if (!city) {
        return res.render("weather", { error: "Місто не знайдено", cities: Object.keys(cityMap) });
    }

    const apiKey = "7f4a351bddd5db7ab96a4851a6ba05aa";
    
    try {
        const response = await axios.get(`https://api.openweathermap.org/data/2.5/weather`, {
            params: {
                q: city,
                appid: apiKey,
                units: "metric",
                lang: "ua"
            }
        });
        const weather = response.data;
        res.render("weather", { weather, cities: Object.keys(cityMap), selectedCity: city });
    } catch (error) {
        res.render("weather", { error: "Місто не знайдено", cities: Object.keys(cityMap) });
    }
});

app.listen(port, () => {
    console.log(`Example app listening on port ${port}`);
});
