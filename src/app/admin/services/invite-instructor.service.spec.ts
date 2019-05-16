import { TestBed, inject } from '@angular/core/testing';

import { InviteInstructorService } from './invite-instructor.service';

describe('InviteInstructorService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [InviteInstructorService]
    });
  });

  it('should be created', inject([InviteInstructorService], (service: InviteInstructorService) => {
    expect(service).toBeTruthy();
  }));
});
