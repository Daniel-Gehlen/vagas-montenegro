export default {
  testEnvironment: 'jsdom',
  setupFilesAfterEnv: ['<rootDir>/tests/setup.js'],
  testMatch: ['**/tests/**/*.test.js'],
  transform: {
    '^.+\\.js$': 'babel-jest'
  },
  collectCoverageFrom: [
    'js/**/*.js',
    '!js/**/*.test.js',
    '!**/node_modules/**'
  ],
  coverageDirectory: 'reports/coverage',
  coverageReporters: ['html', 'text', 'lcov'],
  moduleNameMapper: {
    '\\.(css|scss)$': 'identity-obj-proxy'
  }
};
