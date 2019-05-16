import { TestBed, inject } from '@angular/core/testing';

import { UserinstructorService } from './userinstructor.service';

describe('UserinstructorService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [UserinstructorService]
    });
  });

  it('should be created', inject([UserinstructorService], (service: UserinstructorService) => {
    expect(service).toBeTruthy();
  }));
});
