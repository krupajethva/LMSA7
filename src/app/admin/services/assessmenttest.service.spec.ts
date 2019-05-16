import { TestBed, inject } from '@angular/core/testing';

import { AssessmenttestService } from './assessmenttest.service';

describe('AssessmenttestService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [AssessmenttestService]
    });
  });

  it('should be created', inject([AssessmenttestService], (service: AssessmenttestService) => {
    expect(service).toBeTruthy();
  }));
});
