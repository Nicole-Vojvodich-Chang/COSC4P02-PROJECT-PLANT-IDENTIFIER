\
describe('Authentication Form Tests', () => {
    beforeAll(() => {
        // Setup HTML elements in the document
        document.documentElement.innerHTML = `
            <div id="signInForm" style="display: none;"></div>
            <div id="signUpForm" style="display: none;"></div>
            <div id="mainResponse"></div>
            <button id="signInBtn">Sign In</button>
            <button id="signUpBtn">Sign Up</button>
            <input id="signInUsernameInput">
            <input id="signInPasswordInput">
            <input id="signUpUsernameInput">
            <input id="signUpPasswordInput">
            <input id="signUpEmailInput">
            <button id="login">Login</button>
        `;
        require('./login-source.js');  
    });

    beforeEach(() => {
        fetch.resetMocks();
    });

    test('Switches to Sign In', () => {
        document.getElementById('signInBtn').click();
        expect(document.getElementById('signInForm').style.display).toBe('block');
        expect(document.getElementById('signUpForm').style.display).toBe('none');
    });

    test('Switches to Sign Up', () => {
        document.getElementById('signUpBtn').click();
        expect(document.getElementById('signUpForm').style.display).toBe('block');
        expect(document.getElementById('signInForm').style.display).toBe('none');
    });

    test('Handles login submission with empty fields', () => {
        document.getElementById('signInBtn').click(); // Ensure sign-in form is visible
        document.getElementById('login').click(); // Simulate login button click
        expect(document.getElementById('mainResponse').textContent).toContain('Please ensure that all fields are filled.');
    });

    test('Handles successful login', async () => {
        fetch.mockResponseOnce(JSON.stringify({ success: true }), { status: 200 });
        document.getElementById('signInUsernameInput').value = 'user';
        document.getElementById('signInPasswordInput').value = 'pass';
        
        // Spy on window.location.assign method
        const assignSpy = jest.spyOn(window.location, 'assign');
        
        // Assuming the login button has an event listener that triggers an async operation
        document.getElementById('login').click();
        await new Promise(r => setTimeout(r, 50)); // Wait for any asynchronous operations to complete
        
        // Check if window.location.assign is called with the correct URL
        expect(assignSpy).toHaveBeenCalledWith('http://localhost:8080/index.html');
        
        // Restore the spy
        assignSpy.mockRestore();
    });
});
