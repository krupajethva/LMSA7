import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InviteInstructorComponent } from './invite-instructor.component';

describe('InviteInstructorComponent', () => {
  let component: InviteInstructorComponent;
  let fixture: ComponentFixture<InviteInstructorComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ InviteInstructorComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InviteInstructorComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
