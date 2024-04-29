// __tests__/app.test.js
require('jest-fetch-mock').enableMocks();
const fs = require('fs');
const path = require('path');
const html = fs.readFileSync(path.resolve(__dirname, './plant.html'), 'utf8');

global.fetch = require('jest-fetch-mock');

function setupFileReaderMock() {
    class MockFileReader {
        onload = null;
        readAsDataURL(blob) {
            if (this.onload) {
                this.onload({ target: { result: 'data:image/jpeg;base64,' + btoa('fake data') } });
            }
        }
        addEventListener(event, handler) {
            this.onload = handler;
        }
    }
    global.FileReader = MockFileReader;
}

describe('Plant Identification Page', () => {
    beforeEach(() => {
        document.documentElement.innerHTML = html.toString();
        setupFileReaderMock();
        require('./script');  // Load your script after the DOM setup
        document.getElementById("loadingIndicator").style.display = 'none';
    });

    afterEach(() => {
        jest.resetModules();
        fetch.resetMocks();
    });

    it('shows loading indicator during plant identification', async () => {
        const loadingIndicator = document.getElementById("loadingIndicator");
        fetch.mockResponseOnce(JSON.stringify({ success: true }));  // Mocking a successful API call
        
        document.getElementById('uploadInput').dispatchEvent(new Event('change', { bubbles: true }));
        expect(loadingIndicator.style.display).toBe('block');
    });

    it('handles API error correctly', async () => {
        const identificationMessage = document.getElementById("identificationMessage");
        fetch.mockRejectOnce(new Error('Failed to fetch'));  // Mocking a fetch failure
        
        await new Promise(resolve => {
            document.getElementById('uploadInput').addEventListener('change', resolve);
            document.getElementById('uploadInput').dispatchEvent(new Event('change', { bubbles: true }));
        });

        // Ensure that the error handling completes
        await new Promise(resolve => setTimeout(resolve, 0));

        // Check for correct error handling and UI updates
        expect(identificationMessage.innerText).toContain('Error fetching image: Failed to fetch');
        expect(document.getElementById("loadingIndicator").style.display).toBe("none");
        expect(document.getElementById("retryButton").style.display).toBe("block");
    });
});
