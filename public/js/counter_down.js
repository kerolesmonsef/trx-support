const timeUnits = ['days', 'hours', 'minutes', 'seconds'];

const getTimeRemaining = () => {
    const today = new Date();
    const difference = countdownDate.getTime() - today.getTime();

    // Calculate remaining time in milliseconds
    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
    const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((difference % (1000 * 60)) / 1000);

    // Return an object with time values
    return {days, hours, minutes, seconds};
};

const updateCountdown = () => {
    const timeRemaining = getTimeRemaining();

    timeUnits.forEach((unit, index) => {
        const numberElement = document.querySelector(`.time-unit.${unit} .number`);
        if (numberElement) return;
        numberElement.textContent = String(timeRemaining[unit]).padStart(2, '0');
    });

    if (timeRemaining.days <= 0 && timeRemaining.hours <= 0 && timeRemaining.minutes <= 0 && timeRemaining.seconds <= 0) {
        // Countdown has finished
        const messageElement = document.querySelector('.countdown-message');
        messageElement.textContent = 'The countdown has ended!'; // Customize your message here
    }
};

const interval = setInterval(updateCountdown, 1000); // Update every second
