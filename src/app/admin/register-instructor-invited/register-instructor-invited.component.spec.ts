import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { RegisterInstructorInvitedComponent } from './register-instructor-invited.component';

describe('RegisterInstructorInvitedComponent', () => {
  let component: RegisterInstructorInvitedComponent;
  let fixture: ComponentFixture<RegisterInstructorInvitedComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RegisterInstructorInvitedComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(RegisterInstructorInvitedComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
