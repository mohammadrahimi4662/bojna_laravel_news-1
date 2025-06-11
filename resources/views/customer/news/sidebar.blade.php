    <div class="col-lg-4 col-md-5 col-sm-12 rounded" style="max-width: 800px;">
        <div class="sticky-top" style="top: 120px;">
            <div class="box-container ">

                <section class="shadow-sm">
                    <div class="bg-white rounded p-3 border">
                        <section class="row">
                            <span class="border-start"></span>
                            <h3 class="h5 fw-bold text-dark mb-3 border-start border-4 border-danger pe-2">دسته‌بندی‌ها
                            </h3>
                        </section>
                        <ul class="list-unstyled">
                            @foreach ($categories as $category)
                            <li class="border-bottom">
                                <a href="{{ route('customer.category.show', $category->slug) }}"
                                    class="d-flex justify-content-between align-items-center py-2 text-decoration-none text-dark hover-blue">
                                    <span>{{ $category->title }}</span>
                                    <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1 small">
                                        {{ $category->news_count }}
                                    </span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </section>


                <section class="shadow-sm mt-3">
                    <div class="bg-white rounded p-3 border">
                        <section class="row">
                            <span class="border-start"></span>
                            <h3 class="h5 fw-bold text-dark mb-3 border-start border-4 border-danger pe-2">شهر بازی
                            </h3>
                        </section>
                        <style>
                            select {
                                font-size: 16px;
                                padding: 8px;
                                margin: 20px auto;
                            }

                            #game-container {
                                width: 250px;
                                height: 400px;
                                margin: auto;
                                position: relative;
                                background-color: #333;
                                border: 2px solid #fff;
                                overflow: hidden;
                            }

                            #car {
                                width: 40px;
                                height: 60px;
                                background-color: red;
                                position: absolute;
                                bottom: 10px;
                                left: 100px;
                                border-radius: 5px;
                            }

                            .obstacle {
                                width: 40px;
                                height: 60px;
                                background-color: yellow;
                                position: absolute;
                                top: 0;
                                left: 100px;
                                border-radius: 5px;
                            }

                            #overlay {
                                position: absolute;
                                width: 100%;
                                height: 100%;
                                background-color: rgba(0, 0, 0, 0.6);
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                z-index: 2;
                            }

                            #overlay h3{
                                color: #F1F1F1;
                            }

                            #start-btn {
                                padding: 10px 20px;
                                font-size: 16px;
                            }

                            #quizGame {
                                max-width: 400px;
                                margin: 30px auto;
                                background-color: #333;
                                padding: 20px;
                                border-radius: 10px;
                                display: none;
                            }

                            #question {
                                font-size: 18px;
                                margin-bottom: 15px;
                            }

                            .option {
                                background-color: #555;
                                padding: 10px;
                                margin: 8px 0;
                                border-radius: 5px;
                                cursor: pointer;
                            }

                            .option:hover {
                                background-color: #777;
                            }

                            #nextBtn {
                                margin-top: 15px;
                                padding: 8px 20px;
                                font-size: 14px;
                                cursor: pointer;
                            }

                            #score {
                                margin-top: 15px;
                                font-size: 16px;
                            }


                        </style>

<div class="games">

                        <label>انتخاب بازی:</label>
                        <select id="gameSelector" class="w-100">
                            <option value="car" selected>🚗 بازی ماشین</option>
                            <option value="quiz">🧠 بازی سوالات</option>
                        </select>

</div>
                        <!-- بازی ماشین -->
                        <div id="carGame">
                            <div id="game-container">
                                <div id="car"></div>
                                <div id="overlay">
                                    <button id="start-btn">🚗 شروع بازی</button>
                                </div>
                            </div>
                        </div>

                        <!-- بازی سوالات -->
                        <div id="quizGame">
                            <div id="question">در حال بارگذاری سوال...</div>
                            <div id="options"></div>
                            <button id="nextBtn">سوال بعدی</button>
                            <div id="score"></div>
                        </div>

                        <script>
                            const gameSelector = document.getElementById("gameSelector");
                            const carGame = document.getElementById("carGame");
                            const quizGame = document.getElementById("quizGame");

                            gameSelector.addEventListener("change", function () {
                                if (this.value === "car") {
                                    carGame.style.display = "block";
                                    quizGame.style.display = "none";
                                } else {
                                    carGame.style.display = "none";
                                    quizGame.style.display = "block";
                                    loadQuiz();
                                }
                            });

                            // بازی ماشین با مانع
                            const car = document.getElementById("car");
                            const overlay = document.getElementById("overlay");
                            const startBtn = document.getElementById("start-btn");
                            const container = document.getElementById("game-container");
                            let gameLoop, obstacle;

                            function createObstacle() {
                                obstacle = document.createElement("div");
                                obstacle.className = "obstacle";
                                obstacle.style.left = Math.floor(Math.random() * 3) * 70 + "px";
                                container.appendChild(obstacle);
                            }

                            function moveObstacle() {
                                if (!obstacle) return;
                                let top = parseInt(obstacle.style.top || "0");
                                top += 5;
                                obstacle.style.top = top + "px";

                                const carRect = car.getBoundingClientRect();
                                const obsRect = obstacle.getBoundingClientRect();

                                if (
                                    carRect.left < obsRect.right &&
                                    carRect.right > obsRect.left &&
                                    carRect.top < obsRect.bottom &&
                                    carRect.bottom > obsRect.top
                                ) {
                                    clearInterval(gameLoop);
                                    overlay.style.display = "flex";
                                    overlay.innerHTML =
                                        "<h3>💥 بازی تمام شد!</h3><button id='start-btn'>🔁 شروع دوباره</button>";
                                    document.getElementById("start-btn").addEventListener("click", startGame);
                                }

                                if (top > 400) {
                                    container.removeChild(obstacle);
                                    createObstacle();
                                }
                            }

                            function startGame() {
                                overlay.style.display = "none";
                                if (obstacle) {
                                    container.removeChild(obstacle);
                                }
                                car.style.left = "100px";
                                createObstacle();
                                gameLoop = setInterval(moveObstacle, 30);
                            }

                            document.addEventListener("keydown", function (e) {
                                const left = parseInt(window.getComputedStyle(car).left);
                                if (e.key === "ArrowLeft" && left > 0) {
                                    car.style.left = (left - 70) + "px";
                                } else if (e.key === "ArrowRight" && left < 180) {
                                    car.style.left = (left + 70) + "px";
                                }
                            });

                            startBtn.addEventListener("click", startGame);

                            // بازی سوالات
                            const questions = [{
                                    question: "پایتخت ایران چیست؟",
                                    options: ["تهران", "مشهد", "اصفهان", "تبریز"],
                                    answer: "تهران"
                                },
                                {
                                    question: "رنگ پرچم ایران کدام است؟",
                                    options: ["قرمز، زرد، آبی", "سبز، سفید، قرمز", "مشکی، سفید، سبز",
                                        "قرمز، سفید، آبی"
                                    ],
                                    answer: "سبز، سفید، قرمز"
                                }
                            ];

                            let currentQuestion = 0;
                            let score = 0;

                            function loadQuiz() {
                                currentQuestion = 0;
                                score = 0;
                                showQuestion();
                                document.getElementById("nextBtn").style.display = "inline-block";
                            }

                            function showQuestion() {
                                const q = questions[currentQuestion];
                                document.getElementById("question").innerText = q.question;
                                const optionsDiv = document.getElementById("options");
                                optionsDiv.innerHTML = "";
                                q.options.forEach(opt => {
                                    const div = document.createElement("div");
                                    div.className = "option";
                                    div.innerText = opt;
                                    div.onclick = () => checkAnswer(opt);
                                    optionsDiv.appendChild(div);
                                });
                                document.getElementById("score").innerText = `امتیاز: ${score}`;
                            }

                            function checkAnswer(opt) {
                                if (opt === questions[currentQuestion].answer) score++;
                                currentQuestion++;
                                if (currentQuestion < questions.length) {
                                    showQuestion();
                                } else {
                                    document.getElementById("question").innerText = "پایان سوالات!";
                                    document.getElementById("options").innerHTML = "";
                                    document.getElementById("nextBtn").style.display = "none";
                                    document.getElementById("score").innerText =
                                        `امتیاز نهایی شما: ${score} از ${questions.length}`;
                                }
                            }

                            document.getElementById("nextBtn").onclick = () => {
                                if (currentQuestion < questions.length) showQuestion();
                            };

                        </script>

                        {{-- <section class="row">
                            <span class="border-start"></span>
                            <h3 class="h5 fw-bold text-dark mb-3 border-start border-4 border-danger pe-2">اوقات شرعی
                                امروز <span id="location-name">(در حال دریافت...)</span></h3>
                        </section>

                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    اذان صبح
                                    <i class="bi bi-info-circle text-primary ms-2" data-bs-toggle="tooltip"
                                        title="پیشنهاد می‌شود ۱۰ دقیقه بعد از وقت اذان نماز اقامه شود"></i>
                                </span>
                                <span id="fajr">--:--</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                طلوع آفتاب
                                <span id="sunrise">--:--</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                اذان ظهر
                                <span id="dhuhr">--:--</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                اذان مغرب
                                <span id="maghrib">--:--</span>
                            </li>
                            <p id="prayer-times-error" class="text-danger mt-3 d-none">سرویس اوقات شرعی در حال حاضر در
                                دسترس نیست.</p>

                        </ul> --}}
                    </div>
                </section>


            </div>


        </div>
    </div>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function () {

        const khorasanCities = [
            { nameFa: "بجنورد", nameEn: "Bojnord", lat: 37.4747, lon: 57.3310 },
            { nameFa: "شیروان", nameEn: "Shirvan", lat: 37.4092, lon: 57.9304 },
            { nameFa: "اسفراین", nameEn: "Esfarayen", lat: 37.0700, lon: 57.5100 },
            { nameFa: "جاجرم", nameEn: "Jajarm", lat: 36.9500, lon: 56.3802 },
            { nameFa: "مانه و سملقان", nameEn: "Maneh va Samalqan", lat: 37.6126, lon: 56.8284 }, // مرکز: آشخانه
            { nameFa: "گرمه", nameEn: "Garmeh", lat: 37.2000, lon: 56.3412 },
            { nameFa: "راز و جرگلان", nameEn: "Raz va Jargalan", lat: 38.2306, lon: 57.0411 } // مرکز: راز
        ];

            function getNearestCity(lat, lon) {
                function getDistance(c1, c2) {
                    const toRad = x => x * Math.PI / 180;
                    const R = 6371;
                    const dLat = toRad(c2.lat - c1.lat);
                    const dLon = toRad(c2.lon - c1.lon);
                    const a = Math.sin(dLat / 2) ** 2 +
                        Math.cos(toRad(c1.lat)) * Math.cos(toRad(c2.lat)) *
                        Math.sin(dLon / 2) ** 2;
                    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                }

                const bojnord = khorasanCities.find(c => c.nameEn === "Bojnord");
                const distToBojnord = getDistance({ lat, lon }, bojnord);

                if (distToBojnord < 35) {
                    return bojnord;
                } else {
                    let nearest = khorasanCities[0];
                    let minDist = getDistance({ lat, lon }, nearest);

                    for (const city of khorasanCities) {
                        const dist = getDistance({ lat, lon }, city);
                        if (dist < minDist) {
                            minDist = dist;
                            nearest = city;
                        }
                    }

                    return nearest;
                }
            }

            function fetchPrayerTimes(city) {
                document.getElementById("location-name").textContent = city.nameFa;

                fetch(`https://api.aladhan.com/v1/timings?latitude=${city.lat}&longitude=${city.lon}&method=7`)
                    .then(res => res.json())
                    .then(data => {
                        const timings = data.data.timings;
                        document.getElementById("fajr").textContent = timings.Fajr;
                        document.getElementById("sunrise").textContent = timings.Sunrise;
                        document.getElementById("dhuhr").textContent = timings.Dhuhr;
                        document.getElementById("maghrib").textContent = timings.Maghrib;
                    })
                    .catch(err => {
                        console.error("خطا در دریافت اوقات شرعی:", err);
                        document.getElementById("prayer-times-error").classList.remove("d-none");
                    });
            }

            navigator.geolocation.getCurrentPosition(
                pos => {
                    const { latitude, longitude } = pos.coords;
                    const nearestCity = getNearestCity(latitude, longitude);
                    fetchPrayerTimes(nearestCity);
                },
                err => {
                    const defaultCity = khorasanCities.find(c => c.nameEn === "Bojnord");
                    fetchPrayerTimes(defaultCity);
                }
            );

            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipTriggerList.forEach(el => {
                new bootstrap.Tooltip(el);
            });
        });

    </script> --}}
