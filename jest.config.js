export default {
  testEnvironment: 'jsdom',
  setupFilesAfterEnv: ['<rootDir>/tests/setup.js'],
  testMatch: ['**/tests/**/*.test.js'],
  collectCoverageFrom: [
    'js/**/*.js',
    '!js/**/*.test.js',
    '!**/node_modules/**'
  ],
  coverageDirectory: 'reports/coverage',
  coverageReporters: ['html', 'text', 'lcov'],
  moduleNameMapping: {
    '\\.(css|scss)$': 'identity-obj-proxy'
  }
};
