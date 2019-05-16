import { TestBed, inject } from '@angular/core/testing';

import { RegisterInstructorInvitedService } from './register-instructor-invited.service';

describe('RegisterInstructorInvitedService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [RegisterInstructorInvitedService]
    });
  });

  it('should be created', inject([RegisterInstructorInvitedService], (service: RegisterInstructorInvitedService) => {
    expect(service).toBeTruthy();
  }));
});
