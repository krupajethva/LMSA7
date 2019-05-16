import { TestBed, inject } from '@angular/core/testing';

import { CoursetopicService } from './coursetopic.service';

describe('CoursetopicService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CoursetopicService]
    });
  });

  it('should be created', inject([CoursetopicService], (service: CoursetopicService) => {
    expect(service).toBeTruthy();
  }));
});
